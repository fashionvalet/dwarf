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
        $this->exists();

        $params = $this->buildParameters([], ['id' => $resourceId]);

        try {
            $result = $this->getClient()->get($params);
            $response = $this->extractSource($result);

            return $response;
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
        $resources = $this->get();

        return $resources->get('hits')[0];
    }

    /**
     * [get description]
     * @return [type] [description]
     */
    public function get()
    {
        $this->exists();

        $params = $this->buildParameters($this->query);

        $results = $this->getClient()->search($params);

        $response = [];
        foreach ($results['hits']['hits'] as $result) {
            $response['hits'][] = $this->extractSource($result);
        }

        $collection = new Collection($response);
        $collection->setTotal($results['hits']['total']);

        return $collection;
    }

    /**
     * [insert description]
     * @param  array  $body       [description]
     * @param  [type] $resourceId [description]
     * @return [type]             [description]
     */
    public function insert(array $body, $resourceId = null)
    {
        $this->exists();

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
        $this->exists();

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
        $this->exists();

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
        $params = $this->buildParameters($this->query);

        return $params;
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

    /**
     * [extractSource description]
     * @param  [type] $source [description]
     * @return [type]         [description]
     */
    protected function extractSource($source)
    {
        $resource['id'] = $source['_id'];
        $resource = array_merge($resource, $source['_source']);

        return new Fluent($resource);
    }
}
