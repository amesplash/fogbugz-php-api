<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Foundation\Contract;

use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

interface HttpFactory extends
    RequestFactoryInterface,
    ResponseFactoryInterface,
    StreamFactoryInterface,
    UriFactoryInterface
{
}
