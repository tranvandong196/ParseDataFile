<?php
/**
 * Created by PhpStorm.
 * User: trandong
 * Date: 29/7/18
 * Time: 9:22 PM
 */


interface IFileManager
{
    public static function open($filename, $option);

    public static function read($handle, $length);

    public static function root();
}