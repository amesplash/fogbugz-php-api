<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Foundation\Collection;

use function array_filter;
use function is_scalar;

final class StringArray extends ArrayCollection
{
    /**
     * {@inheritdoc}
     */
    public function __construct(array $elements)
    {
        $stringElements = array_filter(
            $elements,
            static function ($element) : bool {
                return is_scalar($element);
            }
        );

        parent::__construct($stringElements);
    }
}
