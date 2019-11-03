<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Foundation\Exception;

use function get_class;
use function gettype;
use function is_object;
use function sprintf;

class MutableValueWasNotAllowed extends Exception
{
    /**
     * @param  mixed $key
     * @param  mixed $value
     */
    public static function forKeyValue($key, $value) : self
    {
        if (is_object($value)) {
            $type = get_class($value);
        } else {
            $type = gettype($value);
        }
        $message = sprintf('Value for %s is mutable type [%s]', $key, $type);

        return new self($message);
    }
}
