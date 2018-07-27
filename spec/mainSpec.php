<?php

namespace spec;

use main;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class mainSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(main::class);
    }
}
