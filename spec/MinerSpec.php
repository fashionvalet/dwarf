<?php

namespace spec\Fv\Dwarf;

use Prophecy\Argument;
use Elasticsearch\Client;
use PhpSpec\ObjectBehavior;
use Fv\Dwarf\Contracts\DocumentInterface as Document;

class MinerSpec extends ObjectBehavior
{
    function let(Client $client, Document $document)
    {
        $this->beConstructedWith($client, $document);
    }

    function it_sets_client_instance($client)
    {
        $this->setClient($client)->shouldReturnAnInstanceOf($this);
    }

    function it_gets_client_instance($client)
    {
        $this->getClient()->shouldReturnAnInstanceOf($client);
    }

    function it_sets_document_instance(Document $document)
    {
        $this->setDocument($document)->shouldReturnAnInstanceOf($this);
    }

    function it_gets_document_instance(Document $document)
    {
        $this->getDocument()->shouldReturnAnInstanceOf($document);
    }

    function it_sets_elasticsearch_index()
    {
        $this->index('foobar')->shouldReturnAnInstanceOf($this);
    }

    function is_gets_elasticsearch_index()
    {
        $this->index('foobar');

        $this->getIndex()->shouldBeEqualTo('foobar');
    }

    function it_sets_elasticsearch_type()
    {
        $this->type('foo')->shouldReturnAnInstanceOf($this);
    }

    function it_gets_elasticsearch_type()
    {
        $this->type('foo');

        $this->getType()->shouldBeEqualTo('foo');
    }
}
