<?php

namespace OOPFinal;

abstract class AbstractValidator
{
    protected $required;
    protected $fabric;
    protected $customValidators = [];

    public function __construct(Validator $fabric)
    {
        $this->fabric = $fabric;
        $this->required = false;
    }

    public function required()
    {
        $this->required = true;
        return $this;
    }

    public function checkCustomValidators($value, $type)
    {
        foreach ($this->customValidators as $name => $checkValue) {
            $stringValidators = $this->fabric->getValidators($type);
            $validator = $stringValidators[$name]($value, $checkValue);
            if (!$validator) {
                return false;
            }
        }
        return true;
    }

    public function test(string $name, mixed $value): self
    {   
        $this->customValidators[$name] = $value;
        return $this;
    }

    public abstract function isValid(mixed $obj): bool;
}
