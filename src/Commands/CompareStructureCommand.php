<?php

namespace App\Console\Commands;

use BpLab\CompareStructure\CompareStructure;
use BpLab\CompareStructure\Config;
use Illuminate\Console\Command;

class CompareStructureCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
    	$new = new CompareStructure(new Config());
	    $new->run();
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
    }
}
