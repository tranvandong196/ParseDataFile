<?php

namespace spec;

use CSVParser;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CSVParserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CSVParser::class);
    }

    function it_throw_exception_when_import_data_with_no_arguments()
    {
        $this->shouldThrow('InvalidArgumentException')->duringImport();
    }

    function it_return_an_seperative_data_with_array_type_when_parse_data()
    {
        $data = "Ling,Mai,55900\nJohnson,Jim,56500";
        $this->import($data);
        $this->parse();

        $result = [['Ling','Mai','55900'],['Johnson','Jim','56500']];

        $this->getDataAsArray()->shouldReturn($result);

    }
}
