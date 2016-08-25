<?php

namespace features\Context;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Symfony\Component\DependencyInjection\ContainerInterface;
use App\Domain\Model\Product;
use Prophecy\Argument;

class Domain implements Context, SnippetAcceptingContext
{
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @Given a test
     */
    public function aTest()
    {
        $repo = $this->container->get('repo.products.prophecy');
        $task = $this->container->get('task.add_product');
        $task->__invoke('some product', 'some price');

        $repo->add(Argument::type(Product::class))->shouldHaveBeenCalled();
    }
}
