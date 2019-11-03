<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Area;

use Amesplash\FogBugzApi\Foundation\Collection\ArrayCollection;

final class Areas extends ArrayCollection
{
    public function __construct(Area ...$area)
    {
        parent::__construct($area);
    }
}
