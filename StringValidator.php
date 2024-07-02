<?php

require_once 'abstractValidator.php';

class StringValidator extends abstractValidator
{
    private $minLength;
    private $contains;

    public function __construct()
    {
        parent::__construct();
        $this->minLength = 0;
    }

    public function contains(string $str)
    {
        $this->contains = $str;
        return $this;
    }

    public function minLength(int $length)
    {
        $this->minLength = $length;
        return $this;
    }

    public function isValid(mixed $str): bool
    {
        if ($this->required) {
            if (is_null($str) || $str == '') {
                return false;
            }
        }

        if (strlen($str) < $this->minLength) {
            return false;
        }

        if (!is_null($this->contains) && !strpos($str, $this->contains)) {
            return false;
        }

        return true;
    }
}