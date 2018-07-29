<?php

namespace spec;

use Employees;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use CSVReaderMock;
use CSVParserMock;

class EmployeesSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Employees::class);
    }

    function it_throw_InvalidArgumentException_when_import_data_that_inject_null_of_filename()
    {
        $this->shouldThrow('InvalidArgumentException')->duringImport(null, new \CSVReader(), new \CSVParser());
    }

    function it_throw_InvalidArgumentException_when_import_data_that_inject_null_of_fileReaderDriver()
    {
        $this->shouldThrow('InvalidArgumentException')->duringImport('data.csv', null, new \CSVParser());
    }

    function it_throw_InvalidArgumentException_when_import_data_that_inject_null_of_fileParserDriver()
    {
        $this->shouldThrow('InvalidArgumentException')->duringImport('data.csv', new \CSVReader(), null);
    }

    function it_throw_InvalidArgumentException_when_inject_employee_is_not_Employee_class()
    {
        $this->shouldThrow('InvalidArgumentException')->duringAddEmployee('123');
    }

    function it_return_false_if_import_empty_data()
    {
        $csvReaderMock = new CSVReaderMock();
        $csvParserMock =  new CSVParserMock();
        $csvParserMock->setDataEmpty();

        $this->import('example', $csvReaderMock, $csvParserMock)->shouldReturn(false);
    }

    function it_return_true_if_import_available_data()
    {
        $csvReaderMock = new CSVReaderMock();
        $csvParserMock =  new CSVParserMock();

        $this->import('example', $csvReaderMock, $csvParserMock)->shouldReturn(true);
    }
}
