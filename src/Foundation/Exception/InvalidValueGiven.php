<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Foundation\Exception;

use RuntimeException;
use function get_class;
use function gettype;
use function is_object;
use function sprintf;
use function var_export;

class InvalidValueGiven extends RuntimeException
{
    /**
     * @param  mixed $value
     * @param  mixed $object
     */
    public static function forEnum($value, $object) : self
    {
        $type = self::resolveType($object);

        return new self(
            sprintf('Value %s is not a valid value for [%s]', $value, $type)
        );
    }

    /**
     * @param mixed $expected
     * @param mixed $value
     */
    public static function expectedNameValue(
        string $name,
        $expected,
        $value
    ) : self {
        $value = self::resolveType($value);
        $message = sprintf(
            'Invalid value for {%s}: expected %s but got %s',
            $name,
            $expected,
            var_export($value, true)
        );

        return new self($message);
    }

    /**
     * @param mixed $type
     */
    private static function resolveType($type) : string
    {
        return is_object($type) === true ? get_class($type) : gettype($type);
    }
}
