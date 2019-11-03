<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Foundation\Exception;

use function sprintf;
use function var_export;

class JsonError extends Exception
{
    public static function whenEncoding(array $data, string $message) : self
    {
        $data = var_export($data, true);

        return new self(
            sprintf('Error: %s occured when encoding %s', $data, $message)
        );
    }

    public static function whenDecoding(string $json, string $message) : self
    {
        return new self(
            sprintf('Error: %s occured when decoding %s', $message, $json)
        );
    }
}
