<?php


namespace Hexlet\Validator\Tests;

use \PHPUnit\Framework\TestCase;
use Hexlet\Validator\Validator;

class ValidatorTest extends TestCase
{
    private $validator;

    public function setUp(): void
    {
        $this->validator = new Validator();
    }

    public function testString()
    {
        $schema = $this->validator->string();
        $schema2 = $this->validator->string();

        $this->assertTrue($schema->isValid(null));
        $this->assertTrue($schema->isValid(''));
        $this->assertTrue($schema->isValid('what does the fox say'));

        $schema->required();

        $this->assertTrue($schema2->isValid(''));
        $this->assertTrue($schema2->isValid(null));
        $this->assertFalse($schema->isValid(''));
        $this->assertTrue($schema->isValid('hexlet'));
        $this->assertTrue($schema->contains('what')->isValid('what does the fox say'));
        $this->assertTrue($this->validator->string()->minLength(10)->minLength(5)->isValid('Hexlet'));
    }

    public function testumber()
    {
        $schema = $this->validator->number();

        $this->assertTrue($schema->isValid(null));

        $schema->required();

        $this->assertFalse($schema->isValid(null));
        $this->assertTrue($schema->isValid(7));
        $this->assertTrue($schema->positive()->isValid(10));

        $schema->range(-5, 5);

        $this->assertFalse($schema->isValid(-3));
        $this->assertTrue($schema->isValid(5));
    }

    public function testArray()
    {
        $schema = $this->validator->array();

        $this->assertTrue($schema->isValid(null));

        $schema->required();

        $this->assertTrue($schema->isValid([]));
        $this->assertTrue($schema->isValid(['hexlet']));

        $schema->sizeof(2);

        $this->assertFalse($schema->isValid(['hexlet']));
        $this->assertTrue($schema->isValid(['hexlet', 'code-basics']));
    }

    public function testShape()
    {
        $schema = $this->validator->array();

        $schema->shape([
        'name' => $this->validator->string()->required(),
        'age' => $this->validator->number()->positive(),
        ]);

        $this->assertTrue($schema->isValid(['name' => 'kolya', 'age' => 100]));
        $this->assertTrue($schema->isValid(['name' => 'maya', 'age' => null])); 
        $this->assertFalse($schema->isValid(['name' => '', 'age' => null]));
        $this->assertFalse($schema->isValid(['name' => 'ada', 'age' => -5]));
        
    }

    public function testAddValidator()
    {
        $fn = fn($value, $start) => str_starts_with($value, $start);

        $this->validator->addValidator('string', 'startWith', $fn);
        $schema = $this->validator->string()->test('startWith', 'H');
        $this->assertFalse($schema->isValid('exlet'));
        $this->assertTrue($schema->isValid('Hexlet'));

        $fn = fn($value, $min) => $value >= $min;
        $this->validator->addValidator('number', 'min', $fn);

        $schema = $this->validator->number()->test('min', 5);
        $this->assertFalse($schema->isValid(4));
        $this->assertTrue($schema->isValid(6));
    }
}