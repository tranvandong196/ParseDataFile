
<?php
/**
 * Created by PhpStorm.
 * User: trandong
 * Date: 29/7/18
 * Time: 10:22 PM
 */

class CSVReaderMock implements ICSVReader
{
    private $isDataEmpty = false;
    public function open($filename, $option, $fileManager)
    {
        return true;
    }

    public function parse()
    {

    }

    public function getCsv()
    {
        return $this->isDataEmpty ?
            [] : [
                ["Dong", "Tran", 60400.00],
                ["Dieu", "Nhi", 23000.00],
                ["Hoang", "Loan", 50300.00]
            ];
    }

    public function setDataEmpty()
    {
        $this->isDataEmpty = true;
    }

    public function getSource()
    {
        return "Dong, Tran, 6040\nHoang, Loan, 50300\nDieu, Nhi, 23000";
    }
}