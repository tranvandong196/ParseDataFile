<?php

namespace spec;

use CSVReader;
use PhpSpec\ObjectBehavior;


class CSVReaderSpec extends ObjectBehavior
{

    function it_is_initializable()
    {
        $this->shouldHaveType(CSVReader::class);
    }

    function it_should_return_data_when_read_mini_file() {
        $this->open(\FileManager::root().'assets/dataTmp.txt', 'r')->shouldEqual(true);

        $dataTmp = "Ling,Mai,55900";
        $this->getData()->shouldEqual($dataTmp);
    }



}
