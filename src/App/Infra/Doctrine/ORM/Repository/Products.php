<?php

namespace App\Infra\Doctrine\ORM\Repository;

use JMS\DiExtraBundle\Annotation as DI;
use Doctrine\ORM\EntityRepository;
use App\Domain\Repository;
use App\Domain\Model\Product;

/**
 * @DI\Service("repo.products")
 * @DI\Tag("repository", attributes={"for"="App\Domain\Model\Product"})
 * @DI\Tag("test_double", attributes={"stub"="App\Domain\Repository\Products"})
 */
class Products extends EntityRepository implements Repository\Products
{
    public function add(Product $product)
    {
        $this->_em->persist($product);
    }

    public function getByName($name): Product
    {
        return $this->findOneBy(['name' => $name]);
    }
}
