<?php namespace Fv\Dwarf\Facades\Laravel;

use Illuminate\Support\Facades\Facade;

class Indexer extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'fv.dwarf.indexer';
    }
}
