<?php

namespace App\Domain\Model;

use App\Domain\Model\Product;

class Catalog
{
    public $products = [];

    public function add(Product $product)
    {
        $this->products[] = $product;
    }
}
