<?php

namespace spec\Fv\Dwarf;

use Elasticsearch\Client;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Elasticsearch\Namespaces\IndicesNamespace;
use Fv\Dwarf\Exceptions\MissingIndexException;
use Fv\Dwarf\Exceptions\MissingIndexTypeException;
use Elasticsearch\Common\Exceptions\Missing404Exception;

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

    function it_finds_resource_by_id_return_null($client, $indices)
    {
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
            ->willThrow(new Missing404Exception);

        $this->index('foo')
            ->type('foo')
            ->find(123)
            ->shouldBeNull();
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

    function it_gets_all_resources($client, $indices)
    {
        $stubResponse = [
            'hits' => [
                'total' => 2,
                'hits' => [
                    [
                        '_index' => 'foo',
                        '_type' => 'foo',
                        '_id' => 123,
                        '_source' => []
                    ],
                    [
                        '_index' => 'foo',
                        '_type' => 'foo',
                        '_id' => 123,
                        '_source' => []
                    ]
                ]
            ]
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

        $client->search([
            'index' => 'foo',
            'type' => 'foo',
            'body' => [
                'query' => [
                    'match_all' => []
                ]
            ]])
            ->shouldBeCalled()
            ->willReturn($stubResponse);

        $this->index('foo')
            ->type('foo')
            ->all()
            ->shouldReturnAnInstanceOf('Fv\Dwarf\Collection');
    }

    function it_gets_first_resource($client, $indices)
    {
        $stubResponse = [
            'hits' => [
                'total' => 2,
                'hits' => [
                    [
                        '_index' => 'foo',
                        '_type' => 'foo',
                        '_id' => 123,
                        '_source' => []
                    ],
                    [
                        '_index' => 'foo',
                        '_type' => 'foo',
                        '_id' => 123,
                        '_source' => []
                    ]
                ]
            ]
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

        $client->search([
            'index' => 'foo',
            'type' => 'foo',
            'body' => [
                'query' => [
                    'match_all' => []
                ]
            ]])
            ->shouldBeCalled()
            ->willReturn($stubResponse);

        $this->index('foo')
            ->type('foo')
            ->matchesAll()
            ->first()
            ->shouldReturnAnInstanceOf('Fv\Dwarf\Fluent');
    }

    function it_dumps_raw_query()
    {
        $stubResponse = [
            'index' => 'foo',
            'type' => 'foo',
            'body' => [
                'query' => [
                    'match_all' => []
                ]
            ]
        ];

        $this->index('foo')
            ->type('foo')
            ->matchesAll()
            ->dump()
            ->shouldReturn($stubResponse);
    }

    function it_sets_match_all_query()
    {
        $this->matchesAll()->shouldReturnAnInstanceOf($this);
    }

    function it_inserts_new_resource($client, $indices)
    {
        $client->indices()
            ->shouldBeCalled()
            ->willReturn($indices);

        $indices->exists(['index' => 'foo'])
            ->shouldBeCalled()
            ->willReturn(true);

        $indices->existsType(['index' => 'foo', 'type' => 'foo'])
            ->shouldBeCalled()
            ->willReturn(true);

        $client->index([
            'index' => 'foo',
            'type' => 'foo',
            'id' => 'foobar',
            'body' => ['foo' => 'bar']
        ])
        ->shouldBeCalled()
        ->willReturn([]);

        $this->index('foo')
            ->type('foo')
            ->insert(['foo' => 'bar'], 'foobar')
            ->shouldBeArray();
    }

    function it_updates_existing_resource($client, $indices)
    {
        $client->indices()
            ->shouldBeCalled()
            ->willReturn($indices);

        $indices->exists(['index' => 'foo'])
            ->shouldBeCalled()
            ->willReturn(true);

        $indices->existsType(['index' => 'foo', 'type' => 'foo'])
            ->shouldBeCalled()
            ->willReturn(true);

        $client->update([
            'index' => 'foo',
            'type' => 'foo',
            'id' => 'foobar',
            'body' => [
                'doc' => [
                    'foo' => 'bar'
                ]
            ]
        ])
        ->shouldBeCalled()
        ->willReturn([]);

        $this->index('foo')
            ->type('foo')
            ->update('foobar', ['foo' => 'bar'])
            ->shouldBeArray();
    }

    function it_deletes_existing_resource($client, $indices)
    {
        $client->indices()
            ->shouldBeCalled()
            ->willReturn($indices);

        $indices->exists(['index' => 'foo'])
            ->shouldBeCalled()
            ->willReturn(true);

        $indices->existsType(['index' => 'foo', 'type' => 'foo'])
            ->shouldBeCalled()
            ->willReturn(true);

        $client->delete([
            'index' => 'foo',
            'type' => 'foo',
            'id' => 'foobar',
        ])
        ->shouldBeCalled()
        ->willReturn([]);

        $this->index('foo')
            ->type('foo')
            ->delete('foobar')
            ->shouldBeArray();
    }
}
