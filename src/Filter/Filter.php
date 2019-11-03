<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Filter;

use Amesplash\FogBugzApi\Foundation\Entity;

final class Filter extends Entity
{
    /** @var string */
    private $name;

    /** @var string */
    private $label;

    /** @var string */
    private $type;

    public function __construct(
        string $name,
        string $label,
        string $type
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;

        parent::__construct();
    }

    public function name() : string
    {
        return $this->name;
    }

    public function label() : string
    {
        return $this->label;
    }

    public function type() : string
    {
        return $this->type;
    }

    public function arrayCopy() : array
    {
        return [
            'name' => $this->name,
            'label' => $this->label,
            'type' => $this->type,
        ];
    }

    public static function makeFromArray(array $data) : self
    {
        return new self(
            $data['name'],
            $data['label'],
            $data['type']
        );
    }
}
