<?php
/**
 * Created by PhpStorm.
 * User: dongtranv
 * Date: 7/30/2018
 * Time: 10:31 AM
 */

class FileManagerMock implements IFileManager
{
    public static $data;

    public static function open($filename, $option)
    {

    }

    public static function read($handle, $length)
    {
        return self::$data;
    }

    public static function root()
    {
        return trim(__DIR__,'spesrc');
    }
}