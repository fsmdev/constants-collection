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
     * @return mixed
     */
    public static function property($value, string $property = "name")
    {
        static::init($property);

        if (!in_array($value, static::$constants[static::class], true)) {
            return null;
        }

        return static::$properties[static::class][$property][$value] ?? null;
    }

    /**
     * @param mixed $value
     * @param string $property
     * @return false|int|null|string
     */
    public static function value($value, $property = "name") {
        static::init($property);

        if (isset(static::$properties[static::class][$property])) {
            $result = array_search($value, static::$properties[static::class][$property], true);
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
        return isset(static::$properties[static::class][$property]) ? static::$properties[static::class][$property] : [];
    }

    /**
     * @return array
     */
    public static function valuesArray()
    {
        static::init();
        return static::$constants[static::class];
    }

    /**
     * @param string $property
     */
    protected static function init($property = '')
    {
        # Init constants list

        if (!isset(static::$constants[static::class])) {
            try {
                static::$constants[static::class] = (new ReflectionClass(static::class))->getConstants();
            } catch (\ReflectionException $e) {
                static::$constants[static::class] = [];
            }
        }

        # Init property

        if ($property) {
            if (isset(static::$properties[static::class][$property])) {
                return;
            }

            $function = "properties" . self::toCamelCase($property);
            static::$properties[static::class][$property] = static::$function();
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
            $result .= ucfirst($part);
        }
        return $result;
    }
}
