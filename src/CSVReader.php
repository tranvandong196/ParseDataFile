<?php

class CSVReader implements ICSVReader
{
    private $source;
    private $csv = [];

    /**
     * @param $filename: string
     * @param $option: string
     * @return bool
     * @throws Exception
     */
    public function open($filename, $option, $FileManager)
    {
        if (!$FileManager)
        {
            $FileManager = FileManager::class;
        }

        $file = $FileManager::open($filename, $option);
        $this->source = $FileManager::read($file, filesize($filename));
        return true;
    }

    /**
     * parse data from $this->source to array, then assign to csv attribute
     */
    public function parse()
    {
        if ($this->source == '') return;

        $rows = explode("\r\n", $this->source);

        $result = [];
        foreach ($rows as $row) {
            $rowTmp = explode(',', $row);
            foreach ($rowTmp as $key => $value) {
                if (preg_match('/^-?(?:\d+|\d*\.\d+)$/', $value)) {
                    $rowTmp[$key] = floatval($rowTmp[$key]);
                }
            }
            $result[] = $rowTmp;
        }
        $this->csv = $result;
    }

    /**
     * @return array
     */
    public function getCsv()
    {
        return $this->csv;
    }


    public function getSource()
    {
        return $this->source;
    }
}
