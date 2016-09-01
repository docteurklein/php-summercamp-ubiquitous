<?php declare(strict_types=1);

namespace App\Infra\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use App\Domain\Model\Basket;

final class AddToCart extends Controller
{
    /**
     * @Rest\Post("/cart/{name}", name="add_to_cart")
     */
    public function __invoke($name)
    {
        $product = $this->get('repo.products')->getByName($name);

        $basket = new Basket;
        $basket->add($product);

        return View::createRouteRedirect('product', [
            'id' => $product->getId(),
        ]);
    }
}
