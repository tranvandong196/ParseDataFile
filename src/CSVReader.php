<?php

require_once ('IFileReader.php');

class CSVReader implements IFileReader
{
    protected $csvName;
    protected $csvFile;
    protected $data;

    public function __construct()
    {

    }

    public function open($filename, $option)
    {
        if (!file_exists($filename)) {
            throw new Exception('File is not exist!');
        }

        $this->csvFile = fopen($filename, $option);
        if (!$this->csvFile) {
            throw new Exception("Can't open file {$filename}");
            return false;
        }

        $this->csvName = $filename;

        $this->data = fread($this->csvFile, filesize($filename));

        return true;
    }

    public function getData()
    {
        return $this->data;
    }

    /**
     * @param IDataParser
     *
     *
     * @return IDataParser
     */
    public function parseData($DataParserDriver)
    {
        $DataParserDriver->importData($this->data);
        return $DataParserDriver;
    }
}
