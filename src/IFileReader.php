<?php

interface IFileReader
{
    public function __construct();

    public function open($filename, $option);

    public function getData();

    public function parseData($DataParserDriver);
}
