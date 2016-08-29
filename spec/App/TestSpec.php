<?php

namespace spec\App;

use App\Test;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TestSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Test::class);
    }

    function its_test_does_stuff() {
        $this->test();
    }
}
