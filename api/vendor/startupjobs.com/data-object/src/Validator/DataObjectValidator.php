<?php
declare(strict_types=1);

namespace StartupJobsCom\Shared\DataObject\Validator;

use \StartupJobsCom\Shared\DataObject\DataObject;
use Symfony\Component\Validator\ConstraintValidator;

abstract class DataObjectValidator extends ConstraintValidator
{

    /**
     * @param string $propertyName
     * @param DataObject $object
     * @return mixed
     * @throws \ReflectionException
     */
    protected function getPropertyValue(string $propertyName, $object)
    {
        try {
            $property = new \ReflectionProperty(get_class($object), $propertyName);
            $property->setAccessible(true);
            $value = $property->getValue($object);
            $property->setAccessible(false);
        } catch (\ReflectionException $e) {
            return null;
        }

        return $value;
    }
}
