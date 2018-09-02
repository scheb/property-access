<?php

namespace Scheb\PropertyAccess\Strategy;

use Scheb\PropertyAccess\Test\TestCase;

class ArrayAccessStrategyTest extends TestCase
{
    /**
     * @var ArrayAccessStrategy
     */
    private $accessStrategy;

    protected function setUp()
    {
        $this->accessStrategy = new ArrayAccessStrategy();
    }

    /**
     * @test
     */
    public function supports_supportedValueObject_returnsTrue(): void
    {
        $returnValue = $this->accessStrategy->supports(['key' => 'value']);
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
    public function getPropertyValue_arrayHasKey_returnValue(): void
    {
        $valueObject = [
            'key' => 'value',
            'property' => 'propertyValue',
        ];

        $returnValue = $this->accessStrategy->getPropertyValue($valueObject, 'property');
        $this->assertEquals('propertyValue', $returnValue);
    }

    /**
     * @test
     */
    public function getPropertyValue_arrayNotHasKey_returnNull(): void
    {
        $valueObject = [
            'key' => 'value',
            'property' => 'propertyValue',
        ];

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
    public function setPropertyValue_arrayWithPropertyGiven_replacePropertyValue(): void
    {
        $valueObject = ['property' => 'currentValue'];
        $returnValue = $this->accessStrategy->setPropertyValue($valueObject, 'property', 'newValue');
        $this->assertArrayHasKey('property', $returnValue);
        $this->assertEquals('newValue', $returnValue['property']);
    }

    /**
     * @test
     */
    public function setPropertyValue_emptyArrayGiven_setPropertyValue(): void
    {
        $valueObject = [];
        $returnValue = $this->accessStrategy->setPropertyValue($valueObject, 'property', 'newValue');
        $this->assertArrayHasKey('property', $returnValue);
        $this->assertEquals('newValue', $returnValue['property']);
    }
}
