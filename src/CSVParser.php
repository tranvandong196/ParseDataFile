<?php


class CSVParser implements IDataParser
{
    private $data;

    public function __construct()
    {

    }

    public function importData($data = null)
    {
        if (!$data) {
            throw new InvalidArgumentException('Function must have an agrument: $data');
        }
        $this->data = $data;
    }

    public function parseToArray()
    {
        $dataLine = explode("\n", $this->data);
        $dataSeperation = array();

        foreach ($dataLine as $value) {
            $dataSeperation[] = explode(',', $value);
        }

        return $dataSeperation;
    }

    function getOriginData()
    {
        return $this->data;
    }
}
