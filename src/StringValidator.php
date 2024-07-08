<?php

namespace Hexlet\Validator;

class StringValidator extends AbstractValidator
{
    private int $minLength;
    private null|string $contains;

    public function __construct($fabric)
    {
        parent::__construct($fabric);
        $this->fabric = $fabric;
        $this->contains = null;
        $this->minLength = 0;
    }

    public function contains(string $str): self
    {
        $this->contains = $str;
        return $this;
    }

    public function minLength(int $length): self
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

        if (!is_null($this->contains) && strpos($str, $this->contains) === false) {
            return false;
        }

        if (!$this->checkCustomValidators($str, 'string')) {
            return false;
        }
        return true;
    }
}
