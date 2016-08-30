<?php

namespace spec\App\Domain\Model;

use App\Domain\Model\Basket;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use App\Domain\Model\Visitor;

class BasketSpec extends ObjectBehavior
{
    function let(Visitor $user)
    {
        $this->beConstructedThrough('forUser', [$user]);
    }

    function its_getOverallPrice_does_stuff() {
        $this->getOverallPrice();
    }
}
