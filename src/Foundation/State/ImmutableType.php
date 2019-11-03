<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Foundation\State;

use Amesplash\FogBugzApi\Foundation\Exception\MutableValueWasNotAllowed;
use DateTimeImmutable;
use Psr\Http\Message\UriInterface;
use function array_merge;
use function is_object;
use function is_scalar;

final class ImmutableType
{
    /** @var array<String> */
    private static $immutableClasses = [
        Immutable::class,
        DateTimeImmutable::class,
        UriInterface::class,
    ];

    /**
     * Disallow construction.
     */
    private function __construct()
    {
    }

    public static function register(string ...$immutableClasses) : void
    {
        self::$immutableClasses = array_merge(
            self::$immutableClasses,
            $immutableClasses
        );
    }

    /**
     * @param mixed $value
     * @param mixed $name
     */
    public static function assertImmutable($value, $name) : void
    {
        if (! self::isImmutable($value)) {
            throw MutableValueWasNotAllowed::forKeyValue($name, $value);
        }
    }

    /**
     * @param mixed $value
     *
     * @suppress PhanRedundantConditionInLoop
     */
    public static function isImmutable($value) : bool
    {
        if ($value === null || is_scalar($value)) {
            return true;
        }

        if (! is_object($value)) {
            return false;
        }

        foreach (self::$immutableClasses as $class) {
            if ($value instanceof $class) {
                return true;
            }
        }

        return false;
    }
}
