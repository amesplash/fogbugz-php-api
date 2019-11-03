<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Foundation\Collection;

use function array_filter;
use function is_int;
use function is_numeric;

final class IntArray extends ArrayCollection
{
    /**
     * {@inheritdoc}
     */
    public function __construct(array $elements)
    {
        $intElements = array_filter(
            $elements,
            static function ($element) : bool {
                if (is_int($element)) {
                    return true;
                }

                return is_numeric($element) && $element === (int) $element;
            }
        );

        parent::__construct($intElements);
    }
}
