<?php

namespace BpLab\CompareStructure;

use Illuminate\Support\Facades\DB;

/**
 * Class Sample
 *
 */
class CompareStructure
{

	const NAME_SINGULAR = 'singular';
	const NAME_PLURAL = 'plural';

    /**
     * @var  \BpLab\CompareStructure\Config
     */
    private $config;

    /**
     * Sample constructor.
     *
     * @param \BpLab\CompareStructure\Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param $name
     *
     * @return  string
     */
    public function run()
    {
        $greeting = $this->config->get('greeting');

	    $conf = [];
	    $conf['model'] = [
		    'name' => self::NAME_SINGULAR
	    ];
	    $conf['db'] = [
		    'name' => self::NAME_PLURAL
	    ];

	    $allTables = [];

	    $databaseName = DB::connection()->getDatabaseName();
	    $tables = DB::select('SHOW TABLES');
	    foreach ($tables as $table) {
		    $allTables[] = $table->{'Tables_in_'.$databaseName};
	    }

	    foreach ($allTables as $oneTable) {
		    if ($conf['db']['name'] == self::NAME_PLURAL) {
			    $realName = $oneTable;
			    if (substr($oneTable, -1) == 's') {
				    $realName = substr($oneTable, 0, -1);
			    }
			    $words = explode('_', $realName);
			    $modelName = '';
			    foreach ($words as $word) {
				    $modelName .= ucfirst($word);
			    }
			    $modelClass = '\\App\\Models\\'.$modelName;
			    if (!class_exists($modelClass)) {
				    $this->line("The model $modelName does not exists");
				    continue;
			    }

			    $newModelClass = new $modelClass;
			    $this->line("The model $modelName exists");
			    $columns = DB::select("SHOW COLUMNS FROM $oneTable");
			    $rules = $newModelClass::$rules;

			    if (empty($rules)) {
				    $this->line("The rules for model $modelName does not exist");
				    continue;
			    }

			    foreach ($columns as $column) {
				    $field = $column->Field;
				    if (!in_array($field, array_keys($rules))) {
					    $this->line("The field $field for model $modelName does not exist in the rules");
				    }

			    }

			    $transformersClasses = [];
			    $transformersClasses[] = '\\App\\Transformers\\V1\\'.$modelName.'Transformer';
			    $transformersClasses[] = '\\App\\Transformers\\V2\\'.$modelName.'Transformer';
			    if (!class_exists($transformersClasses[0]) && !class_exists($transformersClasses[1])) {
				    $this->line("The transformer $transformersClasses[0] or $transformersClasses[1] does not exists");
				    continue;
			    }
		    }
	    }
    }

}
