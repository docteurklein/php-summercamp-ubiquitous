<?php declare(strict_types=1);

namespace App\Domain\Task;

use App\Domain\Model\Product;
use App\Domain\Repository\Products;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service("task.add_product")
 * @DI\Tag("transactional")
 */
final class AddProduct
{
    private $products;

    /**
     * @DI\InjectParams({
     *     "products" = @DI\Inject("repo.products"),
     * })
     */
    public function __construct(Products $products)
    {
        $this->products = $products;
    }

    public function __invoke($name, $price)
    {
        $this->products->add(new Product($name, $price));
    }
}
