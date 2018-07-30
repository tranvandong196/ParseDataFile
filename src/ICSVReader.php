<?php

interface ICSVReader
{
    public function open($filename, $option, $FileManager);

    public function parse();

    public function getCsv();

    public function getSource();
}
