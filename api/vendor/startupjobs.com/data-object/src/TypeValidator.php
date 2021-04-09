<?php
declare(strict_types=1);

namespace StartupJobsCom\Shared\DataObject;

/** TODO Support for union types when PHP 8 is released */
class TypeValidator
{
    public const DOCBLOCK_REGEX = '/@var ((?:(?:[\w?|\\\\<>])+(?:\[])?)+)/';

    public bool $isNullable;
    public bool $isMixed;
    public bool $isArray;
    public bool $hasDefaultValue; // investigate isDefault function
    public ?string $allowedType;
    public ?string $allowedArrayType;

    /**
     * FieldValidator constructor.
     * @param \ReflectionProperty $property
     */
    public function __construct(\ReflectionProperty $property)
    {
        //$this->hasDefaultValue = $property->isDefault();
        $this->isNullable = $this->resolveIsNullable($property);
        $this->isMixed = $this->resolveIsMixed($property);
        $this->isArray = $this->resolveIsArray($property);
        $this->allowedType = $this->resolveAllowedType($property);
        $this->allowedArrayType = $this->resolveAllowedArrayType($property);
    }

    /**
     * @param \ReflectionProperty $property
     * @return bool
     */
    private function resolveIsNullable(\ReflectionProperty $property): bool
    {
        if (!$property->getType()) {
            return true;
        }

        return $property->getType()->allowsNull();
    }

    /**
     * @param \ReflectionProperty $property
     * @return bool
     */
    private function resolveIsMixed(\ReflectionProperty $property): bool
    {
        return !$property->hasType();
    }

    /**
     * @param \ReflectionProperty $property
     * @return bool
     */
    private function resolveIsArray(\ReflectionProperty $property): bool
    {
        $reflectionType = $property->getType();

        if (!$reflectionType instanceof \ReflectionNamedType) {
            return false;
        }

        return (in_array($reflectionType->getName(), ['iterable', 'array']));
    }

    /**
     * @param \ReflectionProperty $property
     * @return string|null
     */
    private function resolveAllowedType(\ReflectionProperty $property): ?string
    {
        return $property->getType() ? $property->getType()->getName() : null;
    }

    public function resolveAllowedArrayType(\ReflectionProperty $property): ?string
    {
        if ($this->resolveIsArray($property)) {
            return $this->parseDocBlockType($property);
        }

        return null;
    }

    /**
     * @param \ReflectionProperty $property
     * @return string|null
     */
    private function parseDocBlockType(\ReflectionProperty $property): ?string
    {
        if (!$docBlock = $property->getDocComment()) {
            return null;
        }

        preg_match(self::DOCBLOCK_REGEX, $docBlock, $matches);
        if (!isset($matches[1])) {
            return null;
        }

        return str_replace('[]', '', array_diff(explode('|', $matches[1]), ['null'])[0]);
    }

    /**
     * @param $value
     * @return bool
     */
    public function isValidType($value): bool
    {
        if ($this->isMixed) {
            return true;
        }

        if (is_iterable($value) && $this->isArray && !$this->allowedArrayType) {
            return true;
        }

        if ($this->isNullable && $value === null) {
            return true;
        }

        if (is_iterable($value)) {
            return $this->isArray && $this->assertValidArrayType($this->allowedArrayType, $value);
        }

        return $this->assertValidType($this->allowedType, $value);

    }

    /**
     * @param string $type
     * @param $collection
     * @return bool
     */
    public function assertValidArrayType(string $type, $collection): bool
    {
        foreach ($collection as $item) {
            if (!$this->assertValidType($type, $item)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string $type
     * @param $value
     * @return bool
     */
    public function assertValidType(string $type, $value): bool
    {
        return $value instanceof $type || $this->normalizeType(gettype($value)) === $type;
    }

    /**
     * @param string $type
     * @return string
     */
    private function normalizeType(string $type): string{
        $typeMap = [
            'integer' => 'int',
            'boolean' => 'bool',
            'double' => 'float',
        ];

        return array_key_exists($type, $typeMap) ? $typeMap[$type] : $type;
    }
}
