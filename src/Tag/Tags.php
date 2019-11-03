<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Tag;

use Amesplash\FogBugzApi\Foundation\Collection\ArrayCollection;

final class Tags extends ArrayCollection
{
    public function __construct(Tag ...$tag)
    {
        parent::__construct($tag);
    }
}
