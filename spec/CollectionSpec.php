<?php

namespace spec\Fv\Dwarf;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CollectionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Fv\Dwarf\Collection');
    }

    function it_gets_total()
    {
        $this->setTotal(10);
        $this->getTotal()->shouldBe(10);
    }
}
