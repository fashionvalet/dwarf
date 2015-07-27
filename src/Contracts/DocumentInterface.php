<?php

namespace Fv\Dwarf\Contracts;

interface DocumentInterface
{
    /**
     * [find description]
     * @param  [type] $resourceId [description]
     * @return [type]             [description]
     */
    public function find($resourceId);

    /**
     * [all description]
     * @return [type] [description]
     */
    public function all();

    /**
     * [first description]
     * @return [type] [description]
     */
    public function first();

    /**
     * [get description]
     * @return [type] [description]
     */
    public function get();
}
