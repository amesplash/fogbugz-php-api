<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Status;

use Amesplash\FogBugzApi\Foundation\Entity;

final class Status extends Entity
{
    /** @var int */
    private $id;

    /** @var string */
    private $label;

    /** @var int */
    private $categoryId;

    /** @var bool */
    private $forWorkDone;

    /** @var bool */
    private $forResolved;

    /** @var bool */
    private $forDuplicate;

    /** @var bool */
    private $forDeleted;

    /** @var bool */
    private $forReactivate;

    /** @var int */
    private $order;

    public function __construct(
        int $id,
        string $label,
        int $categoryId,
        bool $forWorkDone,
        bool $forResolved,
        bool $forDuplicate,
        bool $forDeleted,
        bool $forReactivate,
        int $order
    ) {
        $this->id = $id;
        $this->label = $label;
        $this->categoryId = $categoryId;
        $this->forWorkDone = $forWorkDone;
        $this->forResolved = $forResolved;
        $this->forDuplicate = $forDuplicate;
        $this->forDeleted = $forDeleted;
        $this->forReactivate = $forReactivate;
        $this->order = $order;

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

    public function categoryId() : int
    {
        return $this->categoryId;
    }

    public function isForWorkDone() : bool
    {
        return $this->forWorkDone;
    }

    public function isForResolved() : bool
    {
        return $this->forResolved;
    }

    public function isForDuplicate() : bool
    {
        return $this->forDuplicate;
    }

    public function isForDeleted() : bool
    {
        return $this->forDeleted;
    }

    public function isForReactivate() : bool
    {
        return $this->forReactivate;
    }

    public function order() : int
    {
        return $this->order;
    }

    public function arrayCopy() : array
    {
        return [
            'id' => $this->id,
            'label' => $this->label,
            'category_id' => $this->categoryId,
            'for_work_done' => $this->forWorkDone,
            'for_resolved' => $this->forResolved,
            'for_duplicate' => $this->forDuplicate,
            'for_deleted' => $this->forDeleted,
            'for_reactivate' => $this->forReactivate,
            'order' => $this->order,
        ];
    }

    public function makeFromArray(array $data) : self
    {
        return new self(
            $data['id'],
            $data['label'],
            $data['category_id'],
            $data['for_work_done'],
            $data['for_resolved'],
            $data['for_duplicate'],
            $data['for_deleted'],
            $data['for_reactivate'],
            $data['order']
        );
    }
}
