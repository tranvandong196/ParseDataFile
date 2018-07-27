<?php
require_once ('Employee.php');

class Employees
{
    public $employees = array();

    public function __construct()
    {
    }

    public function importData($filename, $FileReaderDriver, $DataPasserDriver)
    {
        if (!$filename || !$FileReaderDriver || !$DataPasserDriver) {
            throw new InvalidArgumentException('Arguments must not null');
        }

        $FileReaderDriver->open($filename, 'r');

        $dataSeperationArray = $FileReaderDriver->parseData($DataPasserDriver)->parseToArray();

        foreach ($dataSeperationArray as $item) {
            $this->employees[] = new Employee($item[0], $item[1], floatval($item[2]));
        }
    }

    public function showEmployees()
    {
        echo $this->formatToTable();
    }

    public function getMaxSizeColumn()
    {
        $firstNameLen = 0;
        $lastNameLen = 0;
        $salaryLen = 0;
        foreach ($this->employees as $employee) {
            $fnLen = strlen($employee->firstName);
            $lnLen = strlen($employee->lastName);
            $sLen = strlen($employee->salary."");

            if ($fnLen > $firstNameLen) $firstNameLen =  $fnLen;
            if ($lnLen > $lastNameLen) $lastNameLen =  $lnLen;
            if ($sLen > $salaryLen) $salaryLen =  $sLen;
        }

        return [$lastNameLen + 3, $firstNameLen + 3, $salaryLen + 3];
    }

    public function sortBySalaryDecrease()
    {
        $countEmp = count($this->employees);
        for ($i = 0; $i < $countEmp - 1; $i++) {
            for ($j = $i + 1; $j < $countEmp; $j++) {
                if ($this->employees[$i]->salary < $this->employees[$j]->salary) {
                    $tmp = $this->employees[$i];
                    $this->employees[$i] = $this->employees[$j];
                    $this->employees[$j] = $tmp;
                }
            }
        }
    }

    public function formatToTable()
    {
        $sizes = $this->getMaxSizeColumn();
        $content = '';
        $content .= 'Last'.str_repeat(' ', $sizes[0] - strlen('Last')).
            'First'.str_repeat(' ', $sizes[1] - strlen('First')).
            'Salary'.str_repeat(' ', $sizes[2] - strlen('Salary'))."\n";

        $content .= str_repeat('-',array_sum($sizes))."\n";
        setlocale(LC_MONETARY, 'en_US');

        foreach ($this->employees as $employee) {
            $content .= $employee->lastName.str_repeat(' ', $sizes[0] - strlen($employee->lastName)).
                $employee->firstName.str_repeat(' ', $sizes[0] - strlen($employee->firstName)).
                $this->money_format('%i', $employee->salary).str_repeat(' ', $sizes[0] - strlen($employee->salary.''))."\n";
        }

        return $content;
    }

    public function addEmployee($employee)
    {
        if (gettype($employee) !== 'object' || get_class($employee) !== 'Employee') {
            throw new InvalidArgumentException('$employee argument must be an Employee::class');
        };
        $this->employees[] = $employee;
    }

    private function money_format($format, $number)
    {
        $regex  = '/%((?:[\^!\-]|\+|\(|\=.)*)([0-9]+)?'.
            '(?:#([0-9]+))?(?:\.([0-9]+))?([in%])/';
        if (setlocale(LC_MONETARY, 0) == 'C') {
            setlocale(LC_MONETARY, '');
        }
        $locale = localeconv();
        preg_match_all($regex, $format, $matches, PREG_SET_ORDER);
        foreach ($matches as $fmatch) {
            $value = floatval($number);
            $flags = array(
                'fillchar'  => preg_match('/\=(.)/', $fmatch[1], $match) ?
                    $match[1] : ' ',
                'nogroup'   => preg_match('/\^/', $fmatch[1]) > 0,
                'usesignal' => preg_match('/\+|\(/', $fmatch[1], $match) ?
                    $match[0] : '+',
                'nosimbol'  => preg_match('/\!/', $fmatch[1]) > 0,
                'isleft'    => preg_match('/\-/', $fmatch[1]) > 0
            );
            $width      = trim($fmatch[2]) ? (int)$fmatch[2] : 0;
            $left       = trim($fmatch[3]) ? (int)$fmatch[3] : 0;
            $right      = trim($fmatch[4]) ? (int)$fmatch[4] : $locale['int_frac_digits'];
            $conversion = $fmatch[5];

            $positive = true;
            if ($value < 0) {
                $positive = false;
                $value  *= -1;
            }
            $letter = $positive ? 'p' : 'n';

            $prefix = $suffix = $cprefix = $csuffix = $signal = '';

            $signal = $positive ? $locale['positive_sign'] : $locale['negative_sign'];
            switch (true) {
                case $locale["{$letter}_sign_posn"] == 1 && $flags['usesignal'] == '+':
                    $prefix = $signal;
                    break;
                case $locale["{$letter}_sign_posn"] == 2 && $flags['usesignal'] == '+':
                    $suffix = $signal;
                    break;
                case $locale["{$letter}_sign_posn"] == 3 && $flags['usesignal'] == '+':
                    $cprefix = $signal;
                    break;
                case $locale["{$letter}_sign_posn"] == 4 && $flags['usesignal'] == '+':
                    $csuffix = $signal;
                    break;
                case $flags['usesignal'] == '(':
                case $locale["{$letter}_sign_posn"] == 0:
                    $prefix = '(';
                    $suffix = ')';
                    break;
            }
            if (!$flags['nosimbol']) {
                $currency = $cprefix .
                    ($conversion == 'i' ? $locale['int_curr_symbol'] : $locale['currency_symbol']) .
                    $csuffix;
            } else {
                $currency = '';
            }
            $space  = $locale["{$letter}_sep_by_space"] ? ' ' : '';

            $value = number_format($value, $right, $locale['mon_decimal_point'],
                $flags['nogroup'] ? '' : $locale['mon_thousands_sep']);
            $value = @explode($locale['mon_decimal_point'], $value);

            $n = strlen($prefix) + strlen($currency) + strlen($value[0]);
            if ($left > 0 && $left > $n) {
                $value[0] = str_repeat($flags['fillchar'], $left - $n) . $value[0];
            }
            $value = implode($locale['mon_decimal_point'], $value);
//        if ($locale["{$letter}_cs_precedes"]) {
//            $value = $prefix . $currency . $space . $value . $suffix;
//        } else {
//            $value = $prefix . $value . $space . $currency . $suffix;
//        }
            if ($width > 0) {
                $value = str_pad($value, $width, $flags['fillchar'], $flags['isleft'] ?
                    STR_PAD_RIGHT : STR_PAD_LEFT);
            }

            $format = str_replace($fmatch[0], $value, $format);
        }
        return $locale['currency_symbol'].$format;
    }
}
