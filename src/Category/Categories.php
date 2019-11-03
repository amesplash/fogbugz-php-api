<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Category;

use Amesplash\FogBugzApi\Foundation\Collection\ArrayCollection;

final class Categories extends ArrayCollection
{
    public function __construct(Category ...$tag)
    {
        parent::__construct($tag);
    }
}
