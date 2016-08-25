<?php

namespace features\Context;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

class Domain implements Context, SnippetAcceptingContext
{
    public function __construct()
    {
    }

    /**
     * @Given a test
     */
    public function aTest()
    {
        $test = new \App\Test;
        $test->test();
    }
}
