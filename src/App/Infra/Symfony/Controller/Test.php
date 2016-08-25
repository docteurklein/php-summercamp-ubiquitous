<?php

namespace App\Infra\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\Get;
use App\Domain\Model\Product;
use Symfony\Component\HttpFoundation\Response;

final class Test extends Controller
{
    /**
     * @Get("/test")
     */
    public function __invoke()
    {
        $this->get('repo.products')->add(new Product);

        return new Response;
    }
}
