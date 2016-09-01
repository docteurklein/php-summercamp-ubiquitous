<?php

namespace features\Context;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use \App\Domain\Model;

/**
 * Defines application features from the specific context.
 */
class Domain implements Context, SnippetAcceptingContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given a product named :name and priced €:price was added to the catalog
     */
    public function aProductNamedAndPricedEuWasAddedToTheCatalog($name, $price)
    {
        $this->product = Model\Product::namedAndPrice($name, (int) $price);
        $this->catalog = new Model\Catalog;
        $this->catalog->add($this->product);
    }

    /**
     * @When I add the :arg1 product from the catalog to the picked up basket
     */
    public function iAddTheProductFromTheCatalogToThePickedUpBasket($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then the overall basket price should be €:arg1
     */
    public function theOverallBasketPriceShouldBeEu($arg1)
    {
        throw new PendingException();
    }
}
