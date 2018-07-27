<?php
/**
 * Created by PhpStorm.
 * User: dongtranv
 * Date: 7/26/2018
 * Time: 12:58 PM
 */

interface IDataParser
{
    public function __construct();

    public function importData($data);

    public function getOriginData();

    public function parseToArray();
}
