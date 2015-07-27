<?php namespace Fv\Dwarf;

use Elasticsearch\Client;

abstract class Miner
{
    /**
     * Elasticsearch client instance
     *
     * @var \Elasticsearch\Client
     */
    protected $client;

    /**
     * [$index description]
     * @var [type]
     */
    protected $index;

    /**
     * [$type description]
     * @var [type]
     */
    protected $type;

    /**
     * [__construct description]
     * @param Client $client [description]
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * [setClient description]
     * @param Client $client [description]
     */
    public function setClient(Client $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * [getClient description]
     * @return [type] [description]
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * [index description]
     * @param  [type] $index [description]
     * @return [type]        [description]
     */
    public function index($index)
    {
        $this->index = $index;

        return $this;
    }

    /**
     * [getIndex description]
     * @return [type] [description]
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * [type description]
     * @param  [type] $type [description]
     * @return [type]       [description]
     */
    public function type($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * [getType description]
     * @return [type] [description]
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * [isIndexExists description]
     * @param  [type]  $index [description]
     * @return boolean        [description]
     */
    public function isIndexExists($index)
    {
        return $this->getClient()->indices()->exists(['index' => $this->getIndex()]);
    }

    /**
     * [isTypeExists description]
     * @param  [type]  $index [description]
     * @param  [type]  $types [description]
     * @return boolean        [description]
     */
    public function isTypeExists($index, $types)
    {
        return $this->getClient()->indices()->existsType([
            'index' => $index,
            'type' => $types
        ]);
    }

    public function exists()
    {
        if (is_null($this->getIndex()) || ! $this->isIndexExists($this->getIndex())) {
            throw new Exceptions\MissingIndexException("Index [{$this->getIndex()}] does not exists");
        }

        if (is_null($this->getType()) || ! $this->isTypeExists($this->getIndex(), $this->getType())) {
            throw new Exceptions\MissingIndexTypeException("Index type [{$this->getType()}] for [{$this->getIndex()}] does not exists");
        }

        return true;
    }

    /**
     * [buildParameters description]
     * @param  [type] $body [description]
     * @param  [type] $args [description]
     * @return [type]       [description]
     */
    protected function buildParameters(array $body = [], array $args = [])
    {
        $params['index'] = $this->getIndex();

        if (! is_null($this->getType())) {
            $params['type'] = $this->getType();
        }

        if (! empty($body)) {
            $params['body'] = $body;
        }

        if (! empty($args)) {
            $params = array_merge($params, $args);
        }

        return $params;
    }
}
