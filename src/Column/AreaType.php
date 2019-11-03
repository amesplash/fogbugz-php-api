<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Column;

use Amesplash\FogBugzApi\Foundation\Entity;

final class AreaType extends Entity
{
    /** @var int */
    private $id;

    /** @var array */
    private $map = [
        0 => 'Normal',
        1 => 'Not Spam',
        2 => 'Undecided',
        3 => 'Spam',
    ];

    public function __construct(int $id)
    {
        $this->id = $id;

        parent::__construct();
    }

    public function id() : ?int
    {
        return $this->id;
    }

    public function label() : string
    {
        return $this->map[$this->id] ?? 'Unknown';
    }

    public function arrayCopy() : array
    {
        return [
            'id' => $this->id,
            'label' => $this->label(),
        ];
    }

    public static function makeFromArray(array $data) : self
    {
        return new self(
            $data['id']
        );
    }
}
