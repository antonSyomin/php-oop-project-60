<?php

namespace Hexlet\Validator;

abstract class AbstractValidator
{
    protected bool $required;
    protected Validator $fabric;
    protected array $customValidators = [];

    public function __construct(Validator $fabric)
    {
        $this->fabric = $fabric;
        $this->required = false;
    }

    public function required(): self
    {
        $this->required = true;
        return $this;
    }

    public function checkCustomValidators(mixed $value, string $type): true
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

    abstract public function isValid(mixed $obj): bool;
}
