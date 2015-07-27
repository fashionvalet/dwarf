<?php

namespace Fv\Dwarf;

use Illuminate\Support\Fluent;
use Illuminate\Support\Collection;

class Document extends Miner implements Contracts\DocumentInterface
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
        $params = $this->buildParameters([], ['id' => $resourceId]);

        return $this->getClient()->get($params);
    }

    /**
     * [all description]
     * @return [type] [description]
     */
    public function all()
    {
        return $this->whereMatchesAll()->get();
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
        $params = $this->buildParameters($this->dump());

        return $this->getClient()->search($params);
    }

    /**
     * [whereMatchesAll description]
     * @return [type] [description]
     */
    public function whereMatchesAll()
    {
        return $this->addToQuery(['match_all' => []]);
    }

    /**
     * [dump description]
     * @return [type] [description]
     */
    public function dump()
    {
        return $this->query;
    }

    /**
     * [addToQuery description]
     * @param [type] $query [description]
     */
    protected function addToQuery($query)
    {
        $this->query['query'] = $query;

        return $this;
    }
}
