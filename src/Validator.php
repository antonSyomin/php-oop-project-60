<?php

namespace Hexlet\Validator;

class Validator
{
    private array $customValidators = [
        'string' => [],
        'number' => [],
        'array' => []
    ];

    public function string(): StringValidator
    {
        return new StringValidator($this);
    }

    public function number(): NumberValidator
    {
        return new NumberValidator($this);
    }

    public function array(): ArrayValidator
    {
        return new ArrayValidator($this);
    }

    public function addValidator(string $type, string $name, callable $fn): void
    {
        if (isset($this->customValidators[$type])) {
            $this->customValidators[$type][$name] = $fn;
        } else {
            throw new \Exception('Validator не поддерживает тип, переданный функции addValidator');
        }
    }

    public function getValidators(string $type): array
    {
        return $this->customValidators[$type];
    }
}
