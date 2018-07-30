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
}
