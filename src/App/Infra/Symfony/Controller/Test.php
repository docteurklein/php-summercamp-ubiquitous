<?php declare(strict_types=1);

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
        $this->get('repo.products')->add(Product::namedAndPriced('test', 21));

        return new Response;
    }
}
