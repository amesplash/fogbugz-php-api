<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Column;

use Amesplash\FogBugzApi\Foundation\Entity;

final class Priority extends Entity
{
    /** @var int */
    private $id;

    /** @var string */
    private $label;

    /**
     * Creates a new Status instance.
     */
    public function __construct(
        int $id,
        string $label
    ) {
        $this->id = $id;
        $this->label = $label;

        parent::__construct();
    }

    public function id() : int
    {
        return $this->id;
    }

    public function label() : string
    {
        return $this->label;
    }

    public function arrayCopy() : array
    {
        return [
            'id' => $this->id,
            'label' => $this->label,
        ];
    }

    public static function makeFromArray(array $data) : self
    {
        return new self(
            $data['id'],
            $data['label'],
        );
    }
}
