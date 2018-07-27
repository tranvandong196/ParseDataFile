<?php

namespace spec;

use Employee;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EmployeeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('Tran', 'Dong', 123000.00);
        $this->shouldHaveType(Employee::class);
    }
}
