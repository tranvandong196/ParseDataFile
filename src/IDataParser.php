<?php
/**
 * Created by PhpStorm.
 * User: dongtranv
 * Date: 7/26/2018
 * Time: 12:58 PM
 */


interface IDataParser
{
    public function import($data);

    public function parse();

    public function getSource();

    public function getDataAsArray();
}
