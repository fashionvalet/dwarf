<?php

namespace Fv\Dwarf;

class Document implements Contracts\DocumentInterface
{
    /**
     * [$query description]
     * @var [type]
     */
    protected $query = [];

    /**
     * [find description]
     * @param  [type] $resourceId [description]
     * @return [type]             [description]
     */
    public function find($resourceId)
    {

    }

    /**
     * [all description]
     * @return [type] [description]
     */
    public function all()
    {

    }

    /**
     * [first description]
     * @return [type] [description]
     */
    public function first()
    {

    }

    /**
     * [get description]
     * @return [type] [description]
     */
    public function get()
    {

    }

    public function whereMatchAll()
    {
        return $this->addToQuery(['match_all' => []]);
    }

    protected function addToQuery($query)
    {
        $this->query['query'] = $query;

        return $this;
    }
}
