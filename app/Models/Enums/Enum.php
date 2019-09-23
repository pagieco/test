<?php

namespace App\Models\Enums;

abstract class Enum
{
    protected static $constCache = [];

    /**
     * Get all the enum keys.
     *
     * @return array
     * @throws \ReflectionException
     */
    public static function getKeys(): array
    {
        return array_keys(self::getConstants());
    }

    /**
     * Get all the enum values.
     *
     * @return array
     * @throws \ReflectionException
     */
    public static function getValues(): array
    {
        return array_values(self::getConstants());
    }

    /**
     * Get a random enum value.
     *
     * @return mixed
     * @throws \ReflectionException
     */
    public static function randomValue()
    {
        $values = self::getValues();

        return $values[array_rand($values)];
    }

    /**
     * Get all of the constants of the class.
     *
     * @return array
     * @throws \ReflectionException
     */
    protected static function getConstants(): array
    {
        $calledClass = get_called_class();

        if (! array_key_exists($calledClass, self::$constCache)) {
            $reflect = new \ReflectionClass($calledClass);

            self::$constCache[$calledClass] = $reflect->getConstants();
        }

        return self::$constCache[$calledClass];
    }
}
