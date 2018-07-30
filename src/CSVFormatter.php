<?php

class CSVFormatter implements ICSVFormatter
{
    private $csv = [];

    private $headers = [];

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers)
    {
        $this->hasHeader = count($headers) > 0;
        $this->headers = $headers;

        return $this->hasHeader;
    }

    private $hasHeader = false;

    /**
     * @param  $source : []
     */
    public function import($csv = [])
    {
        if (!$csv) {
            throw new InvalidArgumentException('Function must have an agrument: $csv');
        }
        $this->csv = $csv;
    }

    public function toString()
    {
        $this->formatCurrency();

        $result = "";
        $widthOfCols = $this->getMaxWidthColumns(3);

        if ($this->hasHeader) {
            $result .= $this->generateHeader($widthOfCols);
        }

        foreach ($this->csv as $row) {
            $result .= $this->generateRow($row, $widthOfCols);
        }

        return $result;
    }

    private function formatCurrency()
    {
        setlocale(LC_MONETARY, 'en_US');
        foreach ($this->csv as $keyA => $row) {
            foreach ($row as $keyB => $column) {
                if (gettype($column) == 'double') {
                    $this->csv[$keyA][$keyB] = $this->money_format('%i', $column);
                }
            }
        }
    }

    public function sortBySalaryDecrease()
    {
        $col = 2;
        $countCsv = count($this->csv);
        for ($i = 0; $i < $countCsv - 1; $i++) {
            for ($j = $i + 1; $j < $countCsv; $j++) {
                if ($this->csv[$i][$col] < $this->csv[$j][$col]) {
                    $tmp = $this->csv[$i][$col];
                    $this->csv[$i][$col] = $this->csv[$j][$col];
                    $this->csv[$j][$col] = $tmp;
                }
            }
        }
    }

    private function getMaxWidthColumns($bonusSpaces = 0)
    {
        $maxWidthColumns = $this->getWidthColumnsInit();
        foreach ($this->csv as $row) {
            foreach ($row as $key => $column) {
                $curLen = strlen($column);
                if ($curLen > $maxWidthColumns[$key]) {
                    $maxWidthColumns[$key] = $curLen;
                }
            }
        }

        foreach ($maxWidthColumns as $key => $item) {
            $maxWidthColumns[$key] += $bonusSpaces;
        }

        return $maxWidthColumns;
    }

    private function getWidthColumnsInit($width = 0)
    {
        $count = count($this->csv[0]);
        $result = [];
        for ($i = 0; $i < $count; $i++) {
            $result[] = $width;
        }
        return $result;
    }

    private function getOffsetSpaces($amount)
    {
        return str_repeat(' ', $amount);
    }

    private function getLineSeperation($length)
    {
        return str_repeat('-', $length) . "\n";
    }

    private function generateRow($row, $widthOfColumns)
    {
        $result = "";
        foreach ($row as $key => $column) {
            $offset = $widthOfColumns[$key] - strlen($column);
            $result .= $column . $this->getOffsetSpaces($offset);
        }
        $result .= "\n";

        return $result;
    }

    private function generateHeader($widthOfColumns)
    {
        $result = "";
        $result .= $this->generateRow($this->headers, $widthOfColumns);
        $result .= $this->getLineSeperation(array_sum($widthOfColumns));

        return $result;
    }

    private function money_format($format, $number)
    {
        $regex = '/%((?:[\^!\-]|\+|\(|\=.)*)([0-9]+)?' .
            '(?:#([0-9]+))?(?:\.([0-9]+))?([in%])/';
        if (setlocale(LC_MONETARY, 0) == 'C') {
            setlocale(LC_MONETARY, '');
        }
        $locale = localeconv();
        preg_match_all($regex, $format, $matches, PREG_SET_ORDER);
        foreach ($matches as $fmatch) {
            $value = floatval($number);
            $flags = array(
                'fillchar' => preg_match('/\=(.)/', $fmatch[1], $match) ?
                    $match[1] : ' ',
                'nogroup' => preg_match('/\^/', $fmatch[1]) > 0,
                'usesignal' => preg_match('/\+|\(/', $fmatch[1], $match) ?
                    $match[0] : '+',
                'nosimbol' => preg_match('/\!/', $fmatch[1]) > 0,
                'isleft' => preg_match('/\-/', $fmatch[1]) > 0
            );
            $width = trim($fmatch[2]) ? (int)$fmatch[2] : 0;
            $left = trim($fmatch[3]) ? (int)$fmatch[3] : 0;
            $right = trim($fmatch[4]) ? (int)$fmatch[4] : $locale['int_frac_digits'];
            $conversion = $fmatch[5];

            $positive = true;
            if ($value < 0) {
                $positive = false;
                $value *= -1;
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
            $space = $locale["{$letter}_sep_by_space"] ? ' ' : '';

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
        return $locale['currency_symbol'] . $format;
    }
}
