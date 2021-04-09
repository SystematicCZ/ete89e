<?php declare(strict_types=1);

namespace StartupJobsCom\Shared\DataObject\Normalizer;

use Doctrine;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

/**
 * Entity normalizer
 */
class PayloadEntityNormalizer implements ContextAwareNormalizerInterface, ContextAwareDenormalizerInterface
{
    protected EntityManagerInterface $entityManager;

    /**
     * PayloadEntityNormalizer constructor.
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager) {
        $this->entityManager = $manager;
    }

    /**
     * @param mixed $data
     * @param string $type
     * @param string|null $format
     * @param array $context
     * @return bool
     */
    public function supportsDenormalization($data, $type, string $format = null, array $context = []): bool
    {
        return $this->isEntity($type) && (is_numeric($data) || is_string($data)) && in_array(Context::PAYLOAD_CONTEXT, $context, true);
    }

    /**
     * @param string|object $class
     *
     * @return bool
     */
    private function isEntity($class): bool
    {
        if (is_object($class)) {
            $class = ($class instanceof Doctrine\Persistence\Proxy)
                ? get_parent_class($class)
                : get_class($class);
        } elseif (is_string($class)) {
            $class = rtrim($class, '[]');
        }

        return !$this->entityManager->getMetadataFactory()->isTransient($class);
    }

    /**
     * @param mixed $data
     * @param string $class
     * @param string|null $format
     * @param array $context
     * @return array|object|null
     */
    public function denormalize($data, $class, string $format = null, array $context = [])
    {
        return $this->entityManager->find($class, $data);
    }

    /**
     * @param mixed $data
     * @param string|null $format
     * @param array $context
     * @return bool
     */
    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return is_object($data) && $this->isEntity($data) && in_array(Context::PAYLOAD_CONTEXT, $context, true);
    }

    /**
     * @param mixed $object
     * @param string|null $format
     * @param array $context
     * @return array|\ArrayObject|bool|float|int|string|null
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        return $object->getId();
    }
}
