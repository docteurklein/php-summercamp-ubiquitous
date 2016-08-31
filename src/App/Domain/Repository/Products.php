<?php declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Product;

interface Products
{
    public function add(Product $product);

    public function getByName($name): Product;
}
