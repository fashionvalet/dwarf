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
}
