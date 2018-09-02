<?php

namespace Scheb\PropertyAccess\Strategy;

class ArrayAccessStrategy implements PropertyAccessStrategyInterface
{
    public function supports($valueObject): bool
    {
        return is_array($valueObject) || $valueObject instanceof \ArrayAccess;
    }

    public function getPropertyValue($valueObject, string $propertyName)
    {
        if (!$this->supports($valueObject)) {
            throw new \InvalidArgumentException('$valueObject must be an array or instance of \\ArrayAccess.');
        }

        return $valueObject[$propertyName] ?? null;
    }

    public function setPropertyValue($valueObject, string $propertyName, $value)
    {
        if (!$this->supports($valueObject)) {
            throw new \InvalidArgumentException('$valueObject must be an array or instance of \\ArrayAccess.');
        }

        $valueObject[$propertyName] = $value;

        return $valueObject;
    }
}
