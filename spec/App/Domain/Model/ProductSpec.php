<?php

namespace spec\App\Domain\Model;

use App\Domain\Model\Product;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProductSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Product::class);
    }

    function its_namedAndPrice_constructs_a_named_product() {
        $this->beConstructedThrough('namedAndPrice', ['name', 10]);
    }
}
