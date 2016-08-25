<?php

namespace features\Context;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\MinkExtension\Context\RawMinkContext;

class Ui extends RawMinkContext implements Context, SnippetAcceptingContext
{
    /**
     * @Given a test
     */
    public function aTest()
    {
        $this->visitPath('/');
    }
}
