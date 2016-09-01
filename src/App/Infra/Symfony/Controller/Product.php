<?php declare(strict_types=1);

namespace App\Infra\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;

final class Product extends Controller
{
    /**
     * @Get("/product/{id}", name="product")
     */
    public function __invoke($id)
    {
        $product = $this->get('repo.products')->find($id);

        return View::create([
            'product' => $product,
        ])
        ->setTemplate('::add_product.html.twig');
    }
}
