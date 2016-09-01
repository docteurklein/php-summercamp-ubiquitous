<?php

namespace App\Domain\Model;

class Product
{
    public static function namedAndPrice(string $name, int $price)
    {
        $product = new self;
        $product->name = $name;
        $product->price = $price;

        return $product;
    }
}
