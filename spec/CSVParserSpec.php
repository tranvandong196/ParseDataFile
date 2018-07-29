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
        $this->shouldThrow('InvalidArgumentException')->duringImportData();
    }

    function it_return_an_seperative_data_with_array_type_when_parse_data()
    {
        $dataOrigin = "Ling,Mai,55900\nJohnson,Jim,56500";
        $this->importData($dataOrigin);

        $dataSeperation = [['Ling','Mai','55900'],['Johnson','Jim','56500']];

        $this->parseToArray()->shouldReturn($dataSeperation);

    }
}
