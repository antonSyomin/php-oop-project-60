<?php

require_once 'StringValidator.php';
require_once 'NumberValidator.php';

class Validator
{
    private $required;

    public function __construct()
    {
        $this->required = false;
    }

    public function string()
    {
        $validator = new StringValidator();
        return $this->required ? $validator->required() : $validator;
    }

    public function number()
    {
        $validator = new NumberValidator();
        return $this->required ? $validator->required() : $validator;
    }

    public function array()
    {
        $validator = new ArrayValidator();
        return $this->required ? $validator->required() : $validator;
    }

    public function required(): Validator
    {
        $this->required = true;
        return $this;
    }
}

$v = new Validator();
/*$schema = $v->string();
$schema2 = $v->string(); // $schema != $schema2
var_dump($schema->isValid(null));
var_dump($schema->isValid(''));
var_dump($schema->isValid('what does the fox say'));
$schema->required();
var_dump($schema2->isValid(''));
var_dump($schema->isValid(null));
var_dump($schema->isValid(''));
var_dump($schema->isValid('hexlet'));
var_dump($schema->contains('what')->isValid('what does the fox say'));
var_dump($v->string()->minLength(10)->minLength(5)->isValid('Hexlet'));*/

$schema = $v->number();

var_dump($schema->isValid(null)); // true

$schema->required();

var_dump($schema->isValid(null)); // false

// Достаточно работать с типом Integer
var_dump($schema->isValid(7)); // true

var_dump($schema->positive()->isValid(10)); // true

$schema->range(-5, 5);

var_dump($schema->isValid(-3)); // false
var_dump($schema->isValid(5));