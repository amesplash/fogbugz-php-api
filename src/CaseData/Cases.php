<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\CaseData;

use Amesplash\FogBugzApi\Foundation\Collection\ArrayCollection;

final class Cases extends ArrayCollection
{
    /**
     * Creates a new Case Array Collection instance.
     */
    public function __construct(SingleCase ...$case)
    {
        parent::__construct($case);
    }
}
