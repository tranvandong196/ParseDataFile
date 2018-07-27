<?php

namespace spec;

use Employees;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EmployeesSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Employees::class);
    }

    function it_throw_InvalidArgumentException_when_import_data_inject_null_of_three_arrgument()
    {
        $this->shouldThrow('InvalidArgumentException')->duringImportData('data.csv', null, null);
    }

    function it_throw_InvalidArgumentException_when_inject_employee_is_not_Employee_class()
    {
        $this->shouldThrow('InvalidArgumentException')->duringAddEmployee('123');
    }
}
