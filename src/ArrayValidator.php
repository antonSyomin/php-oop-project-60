<?php

namespace Hexlet\Validator;

class ArrayValidator extends AbstractValidator
{
    private null|int $sizeof;
    private array $shapeValidator;

    public function __construct(Validator $fabric)
    {
        parent::__construct($fabric);
        $this->sizeof = null;
        $this->shapeValidator = [];
    }

    public function sizeof(int $size): self
    {
        $this->sizeof = $size;
        return $this;
    }

    public function shape(array $arr): void
    {
        $this->shapeValidator = $arr;
    }

    public function isValid(mixed $arr): bool
    {
        if ($this->required && !is_array($arr)) {
            var_dump($this->required);
            return false;
        }

        if (!is_null($this->sizeof) && count($arr) !== $this->sizeof) {
            return false;
        }

        if (!empty($this->shapeValidator)) {
            foreach ($this->shapeValidator as $key => $value) {
                if (!$value->isValid($arr[$key])) {
                    return false;
                }
            }
        }

        if (!$this->checkCustomValidators($arr, 'string')) {
            return false;
        }
        return true;
    }
}
