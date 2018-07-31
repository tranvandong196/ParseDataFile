<?php
/**
 * Created by PhpStorm.
 * User: dongtranv
 * Date: 7/27/2018
 * Time: 4:50 PM
 */

require_once __DIR__ . '/vendor/autoload.php';


$filename = __DIR__ . '/assets/data.csv';

$csvReader = new CSVReader();
try {
    $csvReader->open($filename, 'r', null);
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
$csvReader->parse();

$csv = $csvReader->getCsv();

$csvFormatter = new CSVFormatter();
$csvFormatter->import($csv);


$csvFormatter->setHeaders(['Last', 'First', 'Salary']);
$csvFormatter->sortBySalaryDecrease();
$csvFormatter->formatCurrency();

echo $csvFormatter->toString();

