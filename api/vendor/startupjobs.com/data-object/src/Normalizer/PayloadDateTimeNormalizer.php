<?php
declare(strict_types=1);

namespace StartupJobsCom\Shared\DataObject\Normalizer;

use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;


class PayloadDateTimeNormalizer extends DateTimeNormalizer implements ContextAwareDenormalizerInterface
{
    /**
     * @param mixed $data
     * @param string|null $format
     * @param array $context
     * @return bool
     */
    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return false;
    }

    /**
     * @param mixed $data
     * @param string $type
     * @param string|null $format
     * @param array $context
     * @return bool
     */
    public function supportsDenormalization($data, string $type, string $format = null, array $context = []): bool
    {
        return parent::supportsDenormalization($data, $type, $format) && in_array(Context::PAYLOAD_CONTEXT, $context, true);
    }


    /**
     * @param mixed $data
     * @param string $type
     * @param string|null $format
     * @param array $context
     * @return array|\DateTime|\DateTimeImmutable|false|object|null
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        if ($data === null || $data === '') {
            return null;
        }

        return parent::denormalize($data, $type, $format, $context);
    }
}
