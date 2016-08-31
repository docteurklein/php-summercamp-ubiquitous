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
        $this->products = $this->container->get('repo.products.prophecy');
    }

    /**
     * @Given a test
     */
    public function aTest()
    {
        $test = new \App\Test();
        $test->test('cu');

        $task = $this->container->get('task.add_product');
        $task('some product', 12);

        $this->products->add(Argument::type(Product::class))->shouldHaveBeenCalled();
    }

    /**
     * @Given a product named :name and priced €:price was added to the catalog
     */
    public function aProductNamedAndPricedWasAddedToThecatalog($name, $price)
    {
        $this->product = \App\Domain\Model\Product::namedAndPriced($name, (int)$price);
        $this->products->getByName($name)->willReturn($this->product);
    }

    /**
     * @When I add the :name product from the catalog to the picked up basket
     */
    public function iAddTheProductFromThecatalogToThePickedUpBasket($name)
    {
        $this->basket = \App\Domain\Model\Basket::forUser(new \App\Domain\Model\Visitor);
        $this->basket->add($this->products->reveal()->getByName($name));
    }

    /**
     * @Then the overall basket price should be €:price
     */
    public function theOverallBasketPriceShouldBe($price)
    {
        if ($this->basket->getOverallPrice() != $price) {
            throw new \Exception($this->basket->getOverallPrice());
        }
    }

    /**
     * @Given an out-of-stock product
     */
    public function anOutOfStockProduct()
    {
        throw new PendingException();
    }

    /**
     * @When I try to add it to my cart
     */
    public function iTryToAddItToMyCart()
    {
        throw new PendingException();
    }

    /**
     * @Then the basket shouldn't be modified
     */
    public function theBasketShouldnTBeModified()
    {
        throw new PendingException();
    }
}
