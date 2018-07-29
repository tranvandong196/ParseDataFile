<?php

class CSVReader implements IFileReader
{
    private $csvName;
    private $csvFile;
    private $data;

    /**
     * @param $filename: string
     * @param $option: string
     * @return bool
     * @throws Exception
     */
    public function open($filename, $option)
    {
        $file = FileManager::open($filename, $option);
        $this->data = FileManager::read($file, filesize($filename));
        return true;
    }

    public function getData()
    {
        return $this->data;
    }
}
