<?php

namespace Scheb\PropertyAccess\Strategy;

use Scheb\PropertyAccess\Test\TestCase;

class ObjectPropertyAccessStrategyTest extends TestCase
{
    /**
     * @var ObjectPropertyAccessStrategy
     */
    private $accessStrategy;

    protected function setUp()
    {
        $this->accessStrategy = new ObjectPropertyAccessStrategy();
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
        $valueObject = new WithPublicProperties();
        $returnValue = $this->accessStrategy->getPropertyValue($valueObject, 'property');
        $this->assertEquals('propertyValue', $returnValue);
    }

    /**
     * @test
     */
    public function getPropertyValue_objectMissingPublicProperty_returnNull(): void
    {
        $valueObject = new WithPublicProperties();
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
        $valueObject = new WithPublicProperties();
        $returnValue = $this->accessStrategy->setPropertyValue($valueObject, 'property', 'newValue');

        /** @var WithPublicProperties $returnValue */
        $this->assertInstanceOf(WithPublicProperties::class, $returnValue);
        $this->assertEquals('newValue', $valueObject->property);
    }

    /**
     * @test
     */
    public function setPropertyValue_objectMissingPublicProperty_returnNullNotSetPropertyValue(): void
    {
        $valueObject = new WithPublicProperties();
        $returnValue = $this->accessStrategy->setPropertyValue($valueObject, 'otherProperty', 'newValue');

        $this->assertNull($returnValue);

        // Make sure the property has not been created
        $valueObjectProperties = array_keys(get_object_vars($valueObject));
        $this->assertNotContains('otherProperty', $valueObjectProperties);
    }
}

class WithPublicProperties
{
    public $property = 'propertyValue';
}
