<?php
/**
 * Created by PhpStorm.
 * User: dongtranv
 * Date: 7/26/2018
 * Time: 12:58 PM
 */


interface ICSVFormatter
{
    public function import($csv);

    public function toString();

    public function sortBySalaryDecrease();
}
