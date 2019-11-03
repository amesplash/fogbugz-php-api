<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Column;

use Amesplash\FogBugzApi\Foundation\Entity;

final class Project extends Entity
{
    /** @var ?int */
    private $id;

    /** @var ?string */
    private $name;

    /**
     * Creates a new Project instance.
     */
    public function __construct(
        ?int $id = null,
        ?string $name = null
    ) {
        $this->id = $id;
        $this->name = $name;

        parent::__construct();
    }

    public function id() : ?int
    {
        return $this->id;
    }

    public function name() : ?string
    {
        return $this->name;
    }

    public function arrayCopy() : array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }

    public static function makeFromArray(array $data) : self
    {
        return new self(
            $data['id'],
            $data['name'],
        );
    }
}
