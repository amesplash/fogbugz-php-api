<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Project;

use Amesplash\FogBugzApi\Foundation\Collection\ArrayCollection;

final class Projects extends ArrayCollection
{
    public function __construct(Project ...$project)
    {
        parent::__construct($project);
    }
}
