<?php

namespace spec\Fv\Dwarf;

use Prophecy\Argument;
use Elasticsearch\Client;
use PhpSpec\ObjectBehavior;

class MinerSpec extends ObjectBehavior
{
    function let(Client $client)
    {
        $this->beConstructedWith($client);
    }

    function it_sets_client_instance($client)
    {
        $this->setClient($client)->shouldReturnAnInstanceOf($this);
    }

    function it_gets_client_instance($client)
    {
        $this->getClient()->shouldReturnAnInstanceOf($client);
    }
}
