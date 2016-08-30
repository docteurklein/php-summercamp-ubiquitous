<?php

namespace spec\App\Domain\Model;

use App\Domain\Model\Product;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProductSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('test', 20);
    }

    function its_getPrice_does_stuff() {
        $this->getPrice();
    }
}
