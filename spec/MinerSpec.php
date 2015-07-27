<?php

namespace spec\Fv\Dwarf;

use Elasticsearch\Client;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MinerSpec extends ObjectBehavior
{
    function let(Client $client)
    {
        $this->beAnInstanceOf('spec\Fv\Dwarf\StubMiner', [$client]);
    }

    function it_sets_client_instance($client)
    {
        $this->setClient($client)->shouldReturnAnInstanceOf($this);
    }

    function it_gets_client_instance($client)
    {
        $this->getClient()->shouldReturnAnInstanceOf($client);
    }

    function it_sets_index()
    {
        $this->index('foobar')->shouldReturnAnInstanceOf($this);
    }

    function it_gets_index()
    {
        $this->index('foobar');
        $this->getIndex()->shouldBeEqualTo('foobar');
    }

    function it_sets_type()
    {
        $this->type('foobar')->shouldReturnAnInstanceOf($this);
    }

    function it_gets_type()
    {
        $this->type('foobar');
        $this->getType()->shouldBeEqualTo('foobar');
    }
}

class StubMiner extends \Fv\Dwarf\Miner
{

}
