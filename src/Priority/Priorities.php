<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Priority;

use Amesplash\FogBugzApi\Foundation\Collection\ArrayCollection;

final class Priorities extends ArrayCollection
{
    public function __construct(Priority ...$priority)
    {
        parent::__construct($priority);
    }
}
