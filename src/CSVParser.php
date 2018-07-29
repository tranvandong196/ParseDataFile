<?php

class CSVParser implements IDataParser
{
    private $source = "";
    private $csv = [];
    private $headers = [];

    /**
     * @param null $source: string
     */
    public function import($source = null)
    {
        if (!$source) {
            throw new InvalidArgumentException('Function must have an agrument: $data');
        }
        $this->source = $source;
    }

    /**
     * parse data from $this->source to array, then assign to csv attribute
     */
    public function parse()
    {
        $rows = explode("\n", $this->source);

        $result = [];
        foreach ($rows as $row) {
            $result[] = explode(',', $row);
        }

        $this->csv = $result;
    }

    /**
     * @return array
     */
    public function getDataAsArray()
    {
        return $this->csv;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }
}
