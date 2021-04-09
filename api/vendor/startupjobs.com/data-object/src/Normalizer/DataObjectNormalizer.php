<?php
declare(strict_types=1);

namespace StartupJobsCom\Shared\DataObject\Normalizer;

use StartupJobsCom\Shared\DataObject\DataObject;

class DataObjectNormalizer extends \Symfony\Component\Serializer\Normalizer\PropertyNormalizer
{
    /**
     * @param mixed $data
     * @param string $format
     * @return bool
     */
    public function supportsNormalization($data, string $format = null): bool
    {
        return parent::supportsNormalization($data, $format) && is_object($data) && $data instanceof DataObject;
    }

    /**
     * @param mixed $data
     * @param string $type
     * @param string $format
     * @return bool
     * @throws \ReflectionException
     */
    public function supportsDenormalization($data, string $type, string $format = null): bool
    {
        return parent::supportsDenormalization($data, $type, $format) && $this->checkType($type);
    }

    /**
     * @param string $type
     * @return bool
     * @throws \ReflectionException
     */
    private function checkType(string $type): bool
    {
        $reflection = new \ReflectionClass($type);
        return $reflection->isSubclassOf(DataObject::class);
    }

    /**
     * @param mixed $object
     * @param string $format
     * @param array $context
     * @return array|\ArrayObject|bool|float|int|mixed|string|null
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        $normalizedData = parent::normalize($object, $format, $context);
        unset($normalizedData['isValid']);

        return $normalizedData;
    }
}
