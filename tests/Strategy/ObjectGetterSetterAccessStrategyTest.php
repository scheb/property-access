<?php

namespace Scheb\PropertyAccess\Strategy;

use Scheb\PropertyAccess\Test\TestCase;

class ObjectGetterSetterAccessStrategyTest extends TestCase
{
    /**
     * @var ObjectGetterSetterAccessStrategy
     */
    private $accessStrategy;

    protected function setUp()
    {
        $this->accessStrategy = new ObjectGetterSetterAccessStrategy();
    }

    /**
     * @test
     */
    public function supports_supportedValueObject_returnsTrue(): void
    {
        $returnValue = $this->accessStrategy->supports(new \stdClass());
        $this->assertTrue($returnValue);
    }

    /**
     * @test
     */
    public function supports_unsupportedValueObject_returnsFalse(): void
    {
        $returnValue = $this->accessStrategy->supports('unsupported');
        $this->assertFalse($returnValue);
    }

    /**
     * @test
     */
    public function getPropertyValue_unsupportedValueObject_throwsInvalidArgumentException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->accessStrategy->getPropertyValue('unsupported', 'property');
    }

    /**
     * @test
     */
    public function getPropertyValue_objectHasPublicProperty_returnValue(): void
    {
        $valueObject = new WithGetterAndSetter();
        $returnValue = $this->accessStrategy->getPropertyValue($valueObject, 'property');
        $this->assertEquals('propertyValue', $returnValue);
    }

    /**
     * @test
     */
    public function getPropertyValue_objectHasPublicBooleanProperty_returnValue(): void
    {
        $valueObject = new WithBooleanGetter();
        $returnValue = $this->accessStrategy->getPropertyValue($valueObject, 'property');
        $this->assertTrue($returnValue);
    }

    /**
     * @test
     */
    public function getPropertyValue_objectMissingPublicProperty_returnNull(): void
    {
        $valueObject = new WithGetterAndSetter();
        $returnValue = $this->accessStrategy->getPropertyValue($valueObject, 'otherProperty');
        $this->assertNull($returnValue);
    }

    /**
     * @test
     */
    public function setPropertyValue_unsupportedValueObject_throwsInvalidArgumentException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $valueObject = 'unsupported';
        $this->accessStrategy->setPropertyValue($valueObject, 'property', 'value');
    }

    /**
     * @test
     */
    public function setPropertyValue_objectHasPublicProperty_returnObjectWithPropertyValue(): void
    {
        $valueObject = new WithGetterAndSetter();
        $returnValue = $this->accessStrategy->setPropertyValue($valueObject, 'property', 'newValue');

        /** @var WithGetterAndSetter $returnValue */
        $this->assertInstanceOf(WithGetterAndSetter::class, $returnValue);
        $this->assertEquals('newValue', $returnValue->getProperty());
    }

    /**
     * @test
     */
    public function setPropertyValue_objectMissingPublicProperty_NotSetPropertyValue(): void
    {
        $valueObject = new WithGetterAndSetter();
        $returnValue = $this->accessStrategy->setPropertyValue($valueObject, 'otherProperty', 'newValue');
        $this->assertNull($returnValue);
    }
}

class WithGetterAndSetter
{
    private $property = 'propertyValue';

    public function getProperty(): string
    {
        return $this->property;
    }

    public function setProperty(string $property): void
    {
        $this->property = $property;
    }
}

class WithBooleanGetter
{
    private $property = true;

    public function isProperty(): bool
    {
        return $this->property;
    }
}
