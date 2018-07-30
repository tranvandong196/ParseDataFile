
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
    public function open($filename, $option)
    {
        return true;
    }

    public function getCsv()
    {
        return $this->isDataEmpty ?
            [] : [
                ["Dong", "Tran", 60400],
                ["Hoang", "Loan", 50300],
                ["Dieu", "Nhi", 23000]
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