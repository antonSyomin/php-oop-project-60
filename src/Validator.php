<?php

namespace OOPFinal;

class Validator
{
    private $customValidators = [
        'string' => [],
        'number' => [],
        'array' => []
    ];

    public function string()
    {
        return new StringValidator($this);
    }

    public function number()
    {
        return new NumberValidator($this);
    }

    public function array()
    {
        return new ArrayValidator($this);
    }

    public function addValidator(string $type, string $name, $fn)
    {
        if (isset($this->customValidators[$type])) {
            $this->customValidators[$type][$name] = $fn;
        } else {
            throw new \Exception('Validator не поддерживает тип, переданный функции addValidator');
        }
    }

    public function getValidators(string $type)
    {
        return $this->customValidators[$type];
    }
}
