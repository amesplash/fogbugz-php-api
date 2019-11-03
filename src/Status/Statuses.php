<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Status;

use Amesplash\FogBugzApi\Foundation\Collection\ArrayCollection;

final class Statuses extends ArrayCollection
{
    public function __construct(Status ...$status)
    {
        parent::__construct($status);
    }
}
