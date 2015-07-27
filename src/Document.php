<?php

namespace Fv\Dwarf;

use Elasticsearch\Common\Exceptions\Missing404Exception;

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

        try {
            $response = $this->getClient()->get($params);

            $resource = ['id' => $response['_id']];
            $resource = array_merge($resource, $response['_source']);

            return new Fluent($resource);
        } catch (Missing404Exception $e) {
            return null;
        }
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
     * [insert description]
     * @param  array  $body       [description]
     * @param  [type] $resourceId [description]
     * @return [type]             [description]
     */
    public function insert(array $body, $resourceId = null)
    {
        $args = [];
        if (! is_null($resourceId)) {
            $args = ['id' => $resourceId];
        }

        $params = $this->buildParameters($body, $args);

        return $this->getClient()->index($params);
    }

    /**
     * [update description]
     * @return [type] [description]
     */
    public function update($resourceId, array $body)
    {
        $params = $this->buildParameters(['doc' => $body], ['id' => $resourceId]);

        return $this->getClient()->update($params);
    }

    /**
     * [delete description]
     * @param  [type] $resourceId [description]
     * @return [type]             [description]
     */
    public function delete($resourceId)
    {
        $params = $this->buildParameters([], ['id' => $resourceId]);

        return $this->getClient()->delete($params);
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
