<?php

namespace spec\Fv\Dwarf;

use Elasticsearch\Client;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Elasticsearch\Namespaces\IndicesNamespace;
use Fv\Dwarf\Exceptions\MissingIndexException;
use Fv\Dwarf\Exceptions\MissingIndexTypeException;

class DocumentSpec extends ObjectBehavior
{
    function let(Client $client, IndicesNamespace $indices)
    {
        $this->beConstructedWith($client);
    }

    function it_finds_resource_by_id($client, $indices)
    {
        $stubResponse = [
            '_index' => 'foo',
            '_type' => 'foo',
            '_id' => 123,
            '_source' => []
        ];

        $client->indices()
            ->shouldBeCalled()
            ->willReturn($indices);

        $indices->exists(['index' => 'foo'])
            ->shouldBeCalled()
            ->willReturn(true);

        $indices->existsType(['index' => 'foo', 'type' => 'foo'])
            ->shouldBeCalled()
            ->willReturn(true);

        $client->get(['index' => 'foo', 'type' => 'foo', 'id' => 123])
            ->shouldBeCalled()
            ->willReturn($stubResponse);

        $this->index('foo')
            ->type('foo')
            ->find(123)
            ->shouldReturnAnInstanceOf('Fv\Dwarf\Fluent');
    }

    function it_finds_resource_by_id_throw_exception($client, $indices)
    {
        $client->indices()
            ->shouldBeCalled()
            ->willReturn($indices);

        $indices->exists(['index' => 'foo'])
            ->shouldBeCalled()
            ->willReturn(false);

        $this->index('foo')
            ->type('foo')
            ->shouldThrow(new MissingIndexException("Index [foo] does not exists"))
            ->duringFind(123);

        $indices->exists(['index' => 'foo'])
            ->shouldBeCalled()
            ->willReturn(true);

        $indices->existsType(['index' => 'foo', 'type' => 'foo'])
            ->shouldBeCalled()
            ->willReturn(false);

        $this->index('foo')
            ->type('foo')
            ->shouldThrow(new MissingIndexTypeException("Index type [foo] for [foo] does not exists"))
            ->duringFind(123);
    }
}
