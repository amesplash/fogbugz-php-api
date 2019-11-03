<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Priority;

use Amesplash\FogBugzApi\Foundation\Entity;

final class Priority extends Entity
{
    /** @var int */
    private $id;

    /** @var string */
    private $label;

    /** @var bool */
    private $isDefault;

    public function __construct(int $id, string $label, bool $isDefault)
    {
        $this->id = $id;
        $this->label = $label;
        $this->isDefault = $isDefault;

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

    public function isDefault() : bool
    {
        return $this->isDefault;
    }

    public function arrayCopy() : array
    {
        return [
            'id' => $this->id,
            'label' => $this->label,
            'isDefault' => $this->isDefault,
        ];
    }

    public function makeFromArray(array $data) : self
    {
        return new self(
            $data['id'],
            $data['label'],
            $data['is_default']
        );
    }
}
