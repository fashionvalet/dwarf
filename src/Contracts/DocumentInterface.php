<?php

namespace Fv\Dwarf\Contracts;

interface DocumentInterface
{
    public function find($resourceId);

    public function all();

    public function first();

    public function get();
}
