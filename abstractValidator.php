<?php


abstract class abstractValidator
{
    protected $required;

    public function __construct()
    {
        $this->required = false;
    }

    public function required()
    {
        $this->required = true;
        return $this;
    }

    public abstract function isValid(mixed $obj): bool;
}