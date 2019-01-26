<?php

namespace Fsmdev\ConstantsCollection;

use ReflectionClass;

abstract class ConstantsCollection
{
    protected static $constants;
    protected static $properties = [];

    /**
     * ConstantsCollection constructor.
     */
    protected function __construct()
    {
    }

    /**
     * @param string $name
     * @param array $params
     * @return array
     */
    public static function __callStatic($name, array $params)
    {
        return [];
    }

    /**
     * @param mixed $value
     * @param string $property
     * @return false|int|null|string
     */
    public static function property($value, $property = "name")
    {
        static::init($property);

        if (!in_array($value, static::$constants, true)) {
            return null;
        }

        if (isset(static::$properties[$property][$value])) {
            $result = static::$properties[$property][$value];
        } else {
            $result = array_search($value, static::$constants, true);
        }

        return $result;
    }

    /**
     * @param mixed $value
     * @param string $property
     * @return false|int|null|string
     */
    public static function value($value, $property = "name") {
        static::init($property);

        if (isset(static::$properties[$property])) {
            $result = array_search($value, static::$properties[$property], true);
            if ($result === false) {
                $result = null;
            }
        } else {
            $result = null;
        }

        return $result;
    }

    /**
     * @param string $property
     * @return array|mixed
     */
    public static function propertiesArray($property = "name")
    {
        static::init($property);
        return isset(static::$properties[$property]) ? static::$properties[$property] : [];
    }

    /**
     * @return array
     */
    public static function valuesArray()
    {
        static::init();
        return static::$constants;
    }

    /**
     * @param string $property
     */
    protected static function init($property = '')
    {
        # Init constants list

        if (!isset(static::$constants)) {
            try {
                static::$constants = (new ReflectionClass(static::class))->getConstants();
            } catch (\ReflectionException $e) {
                static::$constants = [];
            }
        }

        # Init property

        if ($property) {
            if (isset(static::$properties[$property])) {
                return;
            }

            $function = "properties" . self::toCamelCase($property);
            static::$properties[$property] = static::$function();
        }
    }

    /**
     * @param string $string
     * @return string
     */
    protected static function toCamelCase($string)
    {
        $result = '';
        $parts = explode('_', $string);
        foreach ($parts as $part) {
            $result = ucfirst($part);
        }
        return $result;
    }
}