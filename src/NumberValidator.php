<?php

namespace Hexlet\Validator;

class NumberValidator extends AbstractValidator
{
    private $positive; 
    private $rangeStart = null;
    private $rangeEnd = null;

    public function __construct($fabric)
    {
        parent::__construct($fabric);
        $this->fabric = $fabric;
        $this->positive = false;
    }

    public function positive()
    {
        $this->positive = true;
        return $this;
    }

    public function range(int $start, int $end)
    {
        $this->rangeStart = $start;
        $this->rangeEnd = $end;
        return $this;
    }

    public function isValid(mixed $number): bool
    {
        if ($this->required && is_null($number)) {
            return false;
        }

        if ($this->positive && $number <= 0 && !is_null($number)) {
            return false;
        }

        if (!is_null($this->rangeStart) && !is_null($this->rangeEnd) 
        && ($number < $this->rangeStart || $number > $this->rangeEnd)) {
            return false;
        }

        if (!$this->checkCustomValidators($number, 'number')) {
            return false;
        }
        return true;
    }
}
