<?php

namespace Scheb\PropertyAccess;

use Scheb\PropertyAccess\Exception\FailedSettingPropertyException;
use Scheb\PropertyAccess\Strategy\PropertyAccessStrategyInterface;

class PropertyAccess implements PropertyAccessInterface
{
    /**
     * @var PropertyAccessStrategyInterface[]
     */
    private $propertyAccessStrategies;

    /**
     * @param PropertyAccessStrategyInterface[] $propertyAccessStrategies
     */
    public function __construct(array $propertyAccessStrategies)
    {
        $this->propertyAccessStrategies = $propertyAccessStrategies;
    }

    public function getPropertyValue($valueObject, string $propertyName)
    {
        foreach ($this->propertyAccessStrategies as $propertyAccessStrategy) {
            if ($propertyAccessStrategy->supports($valueObject)) {
                $value = $propertyAccessStrategy->getPropertyValue($valueObject, $propertyName);
                if (null !== $value) {
                    return $value;
                }
            }
        }

        return null;
    }

    public function setPropertyValue($valueObject, string $propertyName, $value)
    {
        foreach ($this->propertyAccessStrategies as $propertyAccessStrategy) {
            if ($propertyAccessStrategy->supports($valueObject)) {
                $modifiedValueObject = $propertyAccessStrategy->setPropertyValue($valueObject, $propertyName, $value);
                if (null !== $modifiedValueObject) {
                    return $valueObject;
                }
            }
        }

        throw new FailedSettingPropertyException('Property "'.$propertyName.'" could not be set.');
    }
}
