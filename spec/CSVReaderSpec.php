<?php

namespace spec;

use CSVReader;
use FileManager;
use FileManagerMock;
use PhpSpec\ObjectBehavior;

class CSVReaderSpec extends ObjectBehavior
{

    function it_is_initializable()
    {
        $this->shouldHaveType(CSVReader::class);
    }

    function it_should_return_data_source_when_read_mini_file() {
        $this->open(FileManager::root().'assets/dataTmp.txt', 'r', FileManager::class)->shouldEqual(true);

        $dataTmp = "Ling,Mai,55900";
        $this->getSource()->shouldEqual($dataTmp);
    }

    function it_should_return_data_source_when_read_a_file_if_inject_null_of_FileManager() {
        $this->open(FileManager::root().'assets/dataTmp.txt', 'r', null)->shouldEqual(true);

        $dataTmp = "Ling,Mai,55900";
        $this->getSource()->shouldEqual($dataTmp);
    }

    function it_return_an_array_data_when_parse_data()
    {
        FileManagerMock::$data = "Ling,Mai,55900\r\nJohnson,Jim,56500";
        $this->open('assets/data.txt', 'r', FileManagerMock::class);
        $this->parse();

        $result = [['Ling','Mai',55900.00],['Johnson','Jim',56500.00]];

        $this->getCsv()->shouldReturn($result);
    }

    function it_return_an_empty_array_data_when_parse_empty_data()
    {
        FileManagerMock::$data = "";
        $this->open('assets/data.txt', 'r',FileManagerMock::class);
        $this->parse();

        $this->getCsv()->shouldReturn([]);
    }

}
