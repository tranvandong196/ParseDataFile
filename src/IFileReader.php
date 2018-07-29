<?php

interface IFileReader
{
    public function open($filename, $option);

    public function getData();
}
