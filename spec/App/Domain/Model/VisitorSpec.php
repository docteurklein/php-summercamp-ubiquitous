<?php

namespace spec\App\Domain\Model;

use App\Domain\Model\Visitor;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class VisitorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Visitor::class);
    }
}
