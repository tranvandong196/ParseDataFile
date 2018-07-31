<?php

namespace spec;

use CSVFormatter;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CSVFormatterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CSVFormatter::class);
    }

    function it_throw_exception_when_import_data_with_null_of_argument()
    {
        $this->shouldThrow('InvalidArgumentException')->duringImport();
    }

    function it_throw_InvalidArgumentException_if_inject_argument_without_array_type_to_setHeaders()
    {
        $this->shouldThrow('TypeError')->duringSetHeaders(123);
    }

    function it_should_return_false_if_inject_an_empty_array_to_setHeaders()
    {
        $this->setHeaders([])->shouldBe(false);
    }

    function it_should_return_false_if_inject_an_available_array_to_setHeaders()
    {
        $this->setHeaders(['One'])->shouldBe(true);
    }

    function it_return_formatted_salary_as_US_currency_if_call_formatCurrency()
    {
        $this->importMockData();
        $this->formatCurrency();

        $result = [
            ["Dong", "Tran", '$60,400.00'],
            ["Dieu", "Nhi", '$23,000.00'],
            ["Hoang", "Loan", '$50,300.00']
        ];

        $this->getCsv()->shouldReturn($result);
    }

    function it_sort_by_salary_decrease()
    {
        $this->importMockData();
        $this->sortBySalaryDecrease();

        $result = [
            ["Dong", "Tran", 60400.00],
            ["Hoang", "Loan", 50300.00],
            ["Dieu", "Nhi", 23000.00]
        ];

        $this->getCsv()->shouldReturn($result);
    }

    function it_return_string_type_when_call_toString()
    {
        $this->importMockData();

        $this->toString()->shouldBeString();
    }

    public function importMockData(): void
    {
        $csvReaderMock = new \CSVReaderMock();
        $csv = $csvReaderMock->getCsv();

        $this->import($csv);
    }
}
