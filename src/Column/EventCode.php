<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Column;

use ReflectionClass;
use function array_flip;
use function str_replace;
use function strtolower;
use function strtoupper;
use function ucwords;

final class EventCode
{
    public const OPENED = 1;
    public const EDITED = 2;
    public const ASSIGNED = 3;
    public const REACTIVATED = 4;
    public const REOPENED = 5;
    public const CLOSED = 6;
    public const MOVED = 7;
    public const UNKNOWN = 8;
    public const REPLIED = 9;
    public const FORWARDED = 10;
    public const RECEIVED = 11;
    public const SORTED = 12;
    public const NOT_SORTED = 13;
    public const RESOLVED = 14;
    public const EMAILED = 15;
    public const RELEASE_NOTED = 16;
    public const DELETED_ATTACHMENT = 17;

    public static function nameForCode(int $code) : string
    {
        $oClass = new ReflectionClass(self::class);
        $constants = array_flip($oClass->getConstants());
        $name = $constants[$code] ?? null;

        return ucwords(strtolower(str_replace('_', ' ', $name)));
    }

    public static function codeForName(string $name) : ?int
    {
        $oClass = new ReflectionClass(self::class);
        $constants = $oClass->getConstants();
        $name = strtoupper(str_replace(' ', '_', $name));

        return $constants[$name] ?? null;
    }
}
