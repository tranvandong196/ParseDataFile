<?php
/**
 * Created by PhpStorm.
 * User: dongtranv
 * Date: 7/27/2018
 * Time: 4:50 PM
 */

require_once __DIR__ . '/vendor/autoload.php';


$filename = __DIR__.'/assets/data.csv';

$employees = new Employees();

$employees->importData($filename, new CSVReader(), new CSVParser());

$employees->sortBySalaryDecrease();

$employees->showEmployees();
