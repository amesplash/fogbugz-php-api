<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Filter;

use Amesplash\FogBugzApi\Foundation\Collection\ArrayCollection;

final class Filters extends ArrayCollection
{
    public function __construct(Filter ...$filter)
    {
        parent::__construct($filter);
    }
}
