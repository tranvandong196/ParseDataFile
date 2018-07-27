<?php

class Employee
{
    public $firstName;
    public $lastName;
    public $salary;

    public function __construct($lastName, $firstName, $salary)
    {
        if (gettype($salary) !== 'double') {
            throw new InvalidArgumentException('$salary must be double');
        };
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->salary = $salary;
    }
}