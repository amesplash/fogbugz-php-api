<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Test;

use function getenv;

if (getenv('TEST_BOOSTRAPPED') === false) {
    include __DIR__ . '/../vendor/autoload.php';
}
