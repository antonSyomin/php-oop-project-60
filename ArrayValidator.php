<?php

require_once 'abstractValidator.php';

class ArrayValidator
{
    private bool $required;
    private bool $positive; 
    private int|null $rangeStart = null;
    private int|null $rangeEnd = null;

    public function __construct()
    {
        $this->required = false;
        $this->positive = false;
    }
    
    public function required()
    {
        $this->required = true;
        return $this;
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

    public function isValid(int|null $number): bool
    {
        if ($this->required && is_null($number)) {
            return false;
        }

        if ($this->positive && $number <= 0) {
            return false;
        }

        if (!is_null($this->rangeStart) && !is_null($this->rangeEnd) 
        && ($number < $this->rangeStart || $number > $this->rangeEnd)) {
            return false;
        }
        return true;
    }

}