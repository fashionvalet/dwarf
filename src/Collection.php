<?php

namespace Fv\Dwarf;

use Illuminate\Support\Collection as BaseCollection;

class Collection extends BaseCollection
{
    protected $total = 0;

    public function setTotal($total)
    {
        $this->total = (int) $total;

        return $this;
    }

    public function getTotal()
    {
        return $this->total;
    }
}
