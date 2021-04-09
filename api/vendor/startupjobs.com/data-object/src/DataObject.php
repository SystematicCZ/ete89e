<?php

namespace StartupJobsCom\Shared\DataObject;

use StartupJobsCom\Shared\DataObject\Exception\InvalidDataInDataObjectException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class DataObject
{
    protected bool $isValid = false;

    /**
     * @param array $parameters
     */
    public function __construct(array $parameters = [])
    {
        $properties = $this->getProperties();

        foreach ($properties as $key => $property) {
            if ($property->getName() === 'isValid') {
                continue;
            }

            $typeValidator = $this->getTypeValidator($property);
            $fieldName = $property->getName();
            $value = $parameters[$fieldName] ?? $this->getPropertyValue($property);

            if (!$typeValidator->isValidType($value)) {
                throw new \TypeError(sprintf('Parameter %s must be of type or instance of %s, %s given.', $fieldName, $typeValidator->allowedType,
                    gettype($value)));
            }

            $this->setPropertyValue($property, $value);
        }
    }

    /**
     * @return \ReflectionProperty[]
     */
    private function getProperties(): array
    {
        $reflection = new \ReflectionClass(static::class);
        return $reflection->getProperties();
    }

    /**
     * @param \ReflectionProperty $property
     * @return TypeValidator
     */
    private function getTypeValidator(\ReflectionProperty $property): TypeValidator
    {
        return new TypeValidator($property);
    }

    /**
     * @param \ReflectionProperty $property
     * @return mixed|null
     */
    private function getPropertyValue(\ReflectionProperty $property)
    {
        $property->setAccessible(true);
        try {
            $value = $property->getValue($this);
        } catch (\Throwable $e) {
            return null;
        }
        $property->setAccessible(false);

        return $value;
    }

    /**
     * @param \ReflectionProperty $property
     * @param $value
     */
    private function setPropertyValue(\ReflectionProperty $property, $value): void
    {
        $property->setAccessible(true);
        $property->setValue($this, $value);
        $property->setAccessible(false);
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        if (strpos($name, 'get') === 0) {
            $attributeName = lcfirst(substr($name, 3));

            return $this->__get($attributeName);
        }

        throw new \RuntimeException(sprintf('Method \'%s\' is not supported by \'%s\'', $name, get_class($this)));
    }

    /**
     * @param $name
     * @return mixed
     * @throws \Exception
     */
    public function __get($name)
    {
        if (!$this->isValid) {
            throw new \RuntimeException('You must first call the \'validate()\' method to be able to retrieve values.');
        }

        if (!property_exists($this, $name)) {
            throw new \RuntimeException('Property \'%s\' does not exist in \'%s\'', $name, get_class($this));
        }

        return $this->{$name};
    }

    /**
     * @param $name
     * @param $value
     * @throws \Exception
     */
    public function __set($name, $value): void
    {
        throw new \RuntimeException('Data objects are immutable');
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name): bool
    {
        return isset($this->{$name});
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->isValid;
    }

    /**
     * @param ValidatorInterface $validator
     * @throws \Exception
     */
    public function validate(ValidatorInterface $validator): void
    {
        $this->validateInnerProperties(get_object_vars($this), $validator);

        $errors = $validator->validate($this);
        if (count($errors) > 0) {
            throw new InvalidDataInDataObjectException($errors->__toString());
        }

        $this->isValid = true;
    }

    /**
     * @param array $properties
     * @param ValidatorInterface $validator
     * @throws \Exception
     */
    private function validateInnerProperties(array $properties, ValidatorInterface $validator): void
    {
        foreach ($properties as $property) {
            if (is_iterable($property)) {
                $this->validateInnerProperties($property, $validator);
            } elseif ($property instanceof self) {
                $property->validate($validator);
            }
        }
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        try {
            return (string)json_encode($this->asArray(), JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            return '{}';
        }
    }

    /**
     * @return array
     */
    public function asArray(): array
    {
        $properties = $this->getProperties();
        $result = [];

        foreach ($properties as $property) {
            $result[$property->getName()] = $this->transformValue($this->getPropertyValue($property));
        }

        return $result;
    }

    /**
     * @param $value
     * @return mixed|null
     */
    private function transformValue($value)
    {
        if (is_iterable($value)) {
            foreach ($value as $key => $val) {
                $value[$key] = $this->transformValue($val);
            }
        } elseif ($value instanceof self) {
            return $value->asArray();
        }

        return $value;
    }
}
