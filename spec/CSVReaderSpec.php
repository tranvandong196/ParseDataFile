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

    function it_should_throw_Exception_if_file_is_not_exist()
    {
        $this->shouldThrow()->duringOpen('data.csv');
    }

    function it_should_return_true_if_opened_file ()
    {
        $this->open($this->root().'assets/data.csv', 'r')->shouldEqual(true);
    }

    function it_should_return_data_when_read_mini_file() {
        $this->open($this->root().'assets/dataTmp.txt', 'r')->shouldEqual(true);

        $dataTmp = "Ling,Mai,55900";
        $this->getData()->shouldEqual($dataTmp);
    }

    private function root()
    {
        return trim(__DIR__,'spesrc');
    }

}
