<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Foundation\Exception;

class ApiRateLimitExceeded extends Exception
{
    /**
     * Create new instance
     */
    public function __construct()
    {
        parent::__construct('Your request has been throttled.', 429);
    }
}
