
<?php
/**
 * Created by PhpStorm.
 * User: trandong
 * Date: 29/7/18
 * Time: 10:22 PM
 */

class CSVReaderMock implements IFileReader
{
    public function open($filename, $option)
    {
        return true;
    }

    public function getData()
    {
        return "Ling,Mai,55900\nJohnson,Jim,56500";
    }
}