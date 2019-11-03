<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Tag;

use Amesplash\FogBugzApi\Foundation\Entity;

final class Tag extends Entity
{
    /** @var int */
    private $id;

    /** @var string */
    private $label;

    /** @var int */
    private $usageCount;

    public function __construct(int $id, string $label, int $usageCount)
    {
        $this->id = $id;
        $this->label = $label;
        $this->usageCount = $usageCount;

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

    public function usageCount() : int
    {
        return $this->usageCount;
    }

    public function arrayCopy() : array
    {
        return [
            'id' => $this->id,
            'label' => $this->label,
            'usageCount' => $this->usageCount,
        ];
    }

    public function makeFromArray(array $data) : self
    {
        return new self(
            $data['id'],
            $data['label'],
            $data['usage_count']
        );
    }
}
