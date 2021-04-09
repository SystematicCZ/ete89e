<?php

namespace StartupJobsCom\Shared\DataObject\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DataObjectTest extends TestCase
{
    public function testAbstractDataObjectEmpty(): void
    {
        $validatorMock = $this->createMock(ValidatorInterface::class);
        $validatorMock->method('validate')->willReturn([]);

        $dataObject = new DataObject([]);
        $this->assertEquals(false, $dataObject->isValid());
        $dataObject->validate($validatorMock);
        $this->assertEquals(true, $dataObject->isValid());
        $this->assertEquals(null, $dataObject->getString());
        $this->assertEquals(null, $dataObject->getArray());
    }

    public function testAbstractDataObjectWithValues(): void
    {
        $validatorMock = $this->createMock(ValidatorInterface::class);
        $validatorMock->method('validate')->willReturn([]);

        $dataObject = new DataObject(['string' => 'string', 'array' => ['array']]);
        $this->assertEquals(false, $dataObject->isValid());
        $dataObject->validate($validatorMock);
        $this->assertEquals(true, $dataObject->isValid());
        $this->assertEquals('string', $dataObject->getString());
        $this->assertEquals(['array'], $dataObject->getArray());
    }

    public function testAbstractDataObjectInvalidAccess(): void
    {
        $this->expectException(\Exception::class);
        $dataObject = new DataObject([]);
        $dataObject->getString();
    }

    public function testAbstractDataObjectInvalidTypeError(): void
    {
        $this->expectException(\TypeError::class);
        $dataObject = new DataObject(['string' => 23]);
    }

    public function testAbstractDataObjectInvalidArrayItemTypeError(): void
    {
        $this->expectException(\TypeError::class);
        $dataObject = new DataObject(['string' => 'string', 'array' => [23]]);
    }

    public function testAbstractDataObjectImmutable(): void
    {
        $this->expectException(\Exception::class);
        $dataObject = new DataObject(['string' => 'string', 'array' => ['string']]);
        $dataObject->__set('string', 'nope');
    }
}

/**
 * Class dataObject
 *
 * @method string|null getString()
 * @method array|null getArray()
 */
class DataObject extends \StartupJobsCom\Shared\DataObject\DataObject{
    protected ?string $string;
    /**
     * @var string[]|null
     */
    protected ?array $array;
}
