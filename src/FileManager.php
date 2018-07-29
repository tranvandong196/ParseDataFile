<?php

class FileManager implements IFileManager
{
    private static $peratingSystem;
    private static $version;

    public static function open($filename, $option)
    {
        if (!file_exists($filename)) {
            throw new Exception('File is not exist!');
        }

        $file = fopen($filename, $option);
        if (!$file) {
            throw new Exception("Can't open file {$filename}");
        }

        return $file;
    }

    public static function read($handle, $length)
    {
        return fread($handle, $length);
    }

    public static function root()
    {
        return trim(__DIR__,'spesrc');
    }
}
