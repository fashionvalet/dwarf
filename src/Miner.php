<?php namespace Fv\Dwarf;

use Elasticsearch\Client;

class Miner
{
    /**
     * Elasticsearch client instance
     *
     * @var \Elasticsearch\Client
     */
    protected $client;

    /**
     * [$document description]
     * @var [type]
     */
    protected $document;

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
    public function __construct(Client $client, Contracts\DocumentInterface $document)
    {
        $this->client = $client;
        $this->document = $document;
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
     * [setDocument description]
     * @param ContractsDocumentInterface $document [description]
     */
    public function setDocument(Contracts\DocumentInterface $document)
    {
        $this->document = $document;

        return $this;
    }

    /**
     * [getDocument description]
     * @return [type] [description]
     */
    public function getDocument()
    {
        return $this->document;
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
}
