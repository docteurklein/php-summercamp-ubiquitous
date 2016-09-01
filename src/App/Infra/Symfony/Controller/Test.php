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
        ($this->get('task.add_product'))('test', 21); // write

        $product = $this->get('repo.products')->getByName('test'); // read

        return new Response(print_r($product, true), 201);
    }
}
