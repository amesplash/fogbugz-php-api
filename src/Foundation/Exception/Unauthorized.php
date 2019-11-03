<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Foundation\Exception;

class Unauthorized extends Exception
{
    public static function attempt() : self
    {
        return new self(
            'Unauthorized attempt. Please check API credentials',
            401
        );
    }

    public static function request() : self
    {
        return new self('Unauthorized to perform your request', 403);
    }
}
