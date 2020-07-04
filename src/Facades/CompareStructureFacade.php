<?php

namespace BpLab\CompareStructure\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class CompareStructure
 *
 */
class CompareStructureFacade extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'compare.structure';
    }
}
