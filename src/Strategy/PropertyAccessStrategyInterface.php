<?php

namespace Scheb\PropertyAccess\Strategy;

interface PropertyAccessStrategyInterface
{
    /**
     * If the strategy supports a specific kind of valueObject.
     *
     * @param mixed $valueObject
     *
     * @return bool
     */
    public function supports($valueObject): bool;

    /**
     * Get a property from an item.
     *
     * @param mixed  $valueObject
     * @param string $propertyName
     *
     * @return mixed|null
     */
    public function getPropertyValue($valueObject, string $propertyName);

    /**
     * Set the property on an item.
     *
     * @param mixed  $valueObject
     * @param string $propertyName
     * @param mixed  $value
     *
     * @return mixed The modified object
     */
    public function setPropertyValue($valueObject, string $propertyName, $value);
}
