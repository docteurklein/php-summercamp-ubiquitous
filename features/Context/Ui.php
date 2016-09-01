<?php

namespace features\Context;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\MinkExtension\Context\RawMinkContext;

class Ui extends RawMinkContext implements Context, SnippetAcceptingContext
{
    public function __construct($container) 
    {
        $this->container = $container;
    }

    /**
     * @Given a test
     */
    public function aTest()
    {
        //$this->visitPath('/test');
        //$this->assertSession()->statusCodeEquals(201);
    }

    /**
     * @Given a product named :name and priced €:price was added to the catalog
     */
    public function aProductNamedAndPricedEuWasAddedToTheCatalog($name, $price)
    {
        $this->visitPath('/product/1');
        $this->assertSession()->statusCodeEquals(200);
    }

    /**
     * @When I add the :arg1 product from the catalog to the picked up basket
     */
    public function iAddTheProductFromTheCatalogToThePickedUpBasket($arg1)
    {
        $this->getSession()->getPage()->pressButton('add to cart');
    }

    /**
     * @Then the overall basket price should be €:price
     */
    public function theOverallBasketPriceShouldBeEu($price)
    {
        $this->visitPath('/cart');
        $this->assertSession()->pageTextContains('overall price: '.$price);
    }
}
