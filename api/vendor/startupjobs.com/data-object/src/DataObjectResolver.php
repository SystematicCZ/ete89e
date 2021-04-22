<?php
declare(strict_types=1);

namespace StartupJobsCom\Shared\DataObject;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DataObjectResolver implements ArgumentValueResolverInterface
{
    public const FORMAT = 'json';
    public const CONTEXT = [\StartupJobsCom\Shared\DataObject\Normalizer\Context::PAYLOAD_CONTEXT];

    private ValidatorInterface $validator;
    private SerializerInterface $serializer;
    private \HTMLPurifier $htmlPurifier;

    /**
     * FormRequestResolver constructor.
     * @param ValidatorInterface $validator
     * @param SerializerInterface $serializer
     * @param \HTMLPurifier $HTMLPurifier
     */
    public function __construct(ValidatorInterface $validator, SerializerInterface $serializer, \HTMLPurifier $HTMLPurifier)
    {
        $this->validator = $validator;
        $this->serializer = $serializer;
        $this->htmlPurifier = $HTMLPurifier;
    }

    /**
     * @param Request $request
     * @param ArgumentMetadata $argument
     * @return bool
     */
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        try {
            $reflection = new \ReflectionClass((string)$argument->getType());
            if ($reflection->isSubclassOf(DataObject::class)) {
                return true;
            }
        } catch (\ReflectionException $e) {
            return false;
        }

        return false;
    }

    /**
     * @param Request $request
     * @param ArgumentMetadata $argument
     * @return \Generator|iterable
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        // creating new instance of DataObject
        $class = $argument->getType();
        $payload = $request->getContent();

        if (!$payload) {
            throw new BadRequestHttpException();
        }

        $data = $this->sanitizePayload($this->serializer->decode($payload, self::FORMAT, self::CONTEXT));
        /**
         * @var $dataObject DataObject
         */
        $dataObject = $this->serializer->denormalize($data, $class, self::FORMAT, self::CONTEXT);
        $dataObject->validate($this->validator);

        yield $dataObject;
    }

    /**
     * @param array $payload
     * @return array
     */
    private function sanitizePayload(array $payload): array
    {
        array_walk_recursive(
            $payload,

            function (&$leaf) {
                if (!is_string($leaf)) {
                    return; // is not XSS-threat
                }

                $leaf = htmlspecialchars_decode($this->htmlPurifier->purify(trim($leaf)));
            },
        );

        return $payload;
    }
}
