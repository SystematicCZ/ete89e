<?php

namespace StartupJobsCom\Shared\DataObject\Tests;
use PHPUnit\Framework\TestCase;

class TypeValidatorTest extends TestCase
{
    /**
     * @param string $class
     * @param string $property
     * @param array $expected
     *
     * @dataProvider fieldValidatorDataProvider
     */
    public function testFieldValidator(string $class, string $property, array $expected): void
    {
        $reflectionProperty = new \ReflectionProperty($class, $property);
        $validator = new \StartupJobsCom\Shared\DataObject\TypeValidator($reflectionProperty);

        $this->assertEquals($expected['isNullable'], $validator->isNullable, 'isNullable fault');
        $this->assertEquals($expected['isArray'], $validator->isArray, 'isArray fault');
        $this->assertEquals($expected['isMixed'], $validator->isMixed, 'isMixed fault');
        //$this->assertEquals($expected['hasDefaultValue'], $validator->hasDefaultValue, 'hasDefaultValue fault');
        $this->assertEquals($expected['allowedType'], $validator->allowedType, 'allowedType fault');
        $this->assertEquals($expected['allowedArrayType'], $validator->allowedArrayType, 'allowedArrayTypeFault');

    }

    public function fieldValidatorDataProvider(): array
    {
        return [
            [
                Simple::class,
                'test',
                [
                    'isNullable' => false,
                    'isArray' => false,
                    'isMixed' => false,
                    //'hasDefaultValue' => false,
                    'allowedType' => 'int',
                    'allowedArrayType' => null,
                ],
            ],
            [
                Nullable::class,
                'test',
                [
                    'isNullable' => true,
                    'isArray' => false,
                    'isMixed' => false,
                    //'hasDefaultValue' => false,
                    'allowedType' => 'string',
                    'allowedArrayType' => null,
                ],
            ],
            [
                Nullable::class,
                'test',
                [
                    'isNullable' => true,
                    'isArray' => false,
                    'isMixed' => false,
                    //'hasDefaultValue' => false,
                    'allowedType' => 'string',
                    'allowedArrayType' => null,
                ],
            ],
            [
                MixedArray::class,
                'test',
                [
                    'isNullable' => false,
                    'isArray' => true,
                    'isMixed' => false,
                    //'hasDefaultValue' => false,
                    'allowedType' => 'array',
                    'allowedArrayType' => null,
                ],
            ],
            [
                TypedArray::class,
                'test',
                [
                    'isNullable' => false,
                    'isArray' => true,
                    'isMixed' => false,
                    //'hasDefaultValue' => false,
                    'allowedType' => 'array',
                    'allowedArrayType' => 'int',
                ],
            ],
            [
                Mixed::class,
                'test',
                [
                    'isNullable' => true,
                    'isArray' => false,
                    'isMixed' => true,
                    //'hasDefaultValue' => false,
                    'allowedType' => null,
                    'allowedArrayType' => null,
                ],
            ],
        ];
    }

    /**
     * @param string $class
     * @param string $property
     * @param $value
     * @param bool $expected
     * @throws \ReflectionException
     *
     * @dataProvider isValidTypeDataProvider
     */
    public function testIsValidType(string $class, string $property, $value, bool $expected): void
    {
        $reflectionProperty = new \ReflectionProperty($class, $property);
        $validator = new \StartupJobsCom\Shared\DataObject\TypeValidator($reflectionProperty);

        $this->assertEquals($expected, $validator->isValidType($value));
    }

    public function isValidTypeDataProvider(): array
    {
        return [
            'Simple bad value' =>
                [
                    Simple::class,
                    'test',
                    'string',
                    false,
                ],
            'Simple good value' =>
                [
                    Simple::class,
                    'test',
                    23,
                    true,
                ],
            'Simple bad null value' =>
                [
                    Simple::class,
                    'test',
                    null,
                    false,
                ],
            'Mixed null value' =>
                [
                    Mixed::class,
                    'test',
                    null,
                    true,
                ],
            'Mixed array value' =>
                [
                    Mixed::class,
                    'test',
                    [],
                    true,
                ],
            'Mixed int value' =>
                [
                    Mixed::class,
                    'test',
                    23,
                    true,
                ],
            'Nullable null value' =>
                [
                    Nullable::class,
                    'test',
                    null,
                    true,
                ],
            'Mixed array bad value' =>
                [
                    MixedArray::class,
                    'test',
                    12,
                    false,
                ],
            'Mixed array good value' =>
                [
                    MixedArray::class,
                    'test',
                    [12],
                    true,
                ],
            'Typed array bad value' =>
                [
                    TypedArray::class,
                    'test',
                    [12, 'bleh'],
                    false,
                ],
            'Typed array good value' =>
                [
                    TypedArray::class,
                    'test',
                    [12, 0],
                    true,
                ],
        ];
    }
}


class Simple
{
    private int $test;
}

class DefaultValue
{
    private int $test = 0;
}

class Mixed
{
    private $test;
}

class Nullable
{
    private ?string $test;
}

class MixedArray
{
    private array $test;
}

class TypedArray
{
    /**
     * @var int[]
     */
    private array $test;
}

