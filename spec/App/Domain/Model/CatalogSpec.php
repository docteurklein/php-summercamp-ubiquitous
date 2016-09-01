<?php

namespace spec\App\Domain\Model;

use App\Domain\Model\Catalog;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use App\Domain\Model\Product;

class CatalogSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Catalog::class);
    }

    function it_stores_products(Product $product) {
        $this->add($product);
        $this->products->shouldHaveCount(1);
    }
}
