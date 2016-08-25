<?php

namespace App\Domain\Task;

use App\Domain\Model\Product;
use App\Domain\Repository\Products;

final class AddProduct
{
    private $products;

    public function __construct(Products $products)
    {
        $this->products = $products;
    }

    public function __invoke($name, $price)
    {
        $this->products->add(new Product($name, $price));
    }
}
