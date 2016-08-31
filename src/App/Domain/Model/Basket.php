<?php declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\Model\Product;
use App\Domain\Model\Visitor;

class Basket
{
    private $visitor;
    private $products = [];

    public function __construct(Visitor $visitor, $shippingCost = 4)
    {
        $this->visitor = $visitor;
        $this->shippingCost = $shippingCost;
    }

    public static function forUser(Visitor $user): self
    {
        return new self($user);
    }

    public function add(Product $product)
    {
        $this->products[] = $product;
    }

    public function getOverallPrice(): int
    {
        return array_sum(array_map( function($product) {
            return $product->getPrice();
        }, $this->products)) + $this->shippingCost;
    }
}
