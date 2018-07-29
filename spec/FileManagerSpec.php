<?php

namespace spec;

use FileManager;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FileManagerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(FileManager::class);
    }

    function it_should_throw_Exception_if_file_is_not_exist()
    {
        $this->shouldThrow()->duringOpen('data.csv');
    }

    function it_should_return_content_if_read_file ()
    {
        $filename = FileManager::root().'assets/data.txt';
        $file = $this->open($filename, 'r');

        $result = "Ling,Mai,55900\nJohnson,Jim,56500";

        $this->read($file, filesize($filename))->shouldReturn($result);
    }

    function it_should_return_directory_path_of_root_as_string_type()
    {
        $this->root()->shouldBeString();
    }
}
