<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\CaseData;

use Amesplash\FogBugzApi\Column\Customer;
use Amesplash\FogBugzApi\Column\Person;
use Amesplash\FogBugzApi\Column\Priority;
use Amesplash\FogBugzApi\Column\Status;
use Amesplash\FogBugzApi\Foundation\Entity;

final class SingleCase extends Entity
{
    /** @var int */
    private $id;

    /** @var int */
    private $parentId;

    /** @var string */
    private $title;

    /** @var Status */
    private $status;

    /** @var Priority */
    private $priority;

    /** @var Customer */
    private $customer;

    /** @var Person */
    private $person;

    /** @var string */
    private $ticketNumber;

    /** @var bool */
    private $opened;

    /** @var bool */
    private $replied;

    /** @var string */
    private $summary;

    /** @var int */
    private $timeEstimate;

    /** @var int */
    private $openedBy;

    /** @var int */
    private $closedBy;

    /** @var int */
    private $resolvedBy;

    /** @var int */
    private $lastEditedBy;

    /** @var int */
    private $duplicateBugIds;

    /** @var int */
    private $originalBugId;

    /**
     * Creates a new Single Case instance.
     */
    public function __construct(
        int $id,
        int $parentId,
        string $title,
        Status $status,
        Priority $priority,
        Customer $customer,
        Person $person,
        string $ticketNumber,
        bool $opened,
        bool $replied,
        string $summary,
        int $timeEstimate,
        int $openedBy,
        int $closedBy = 0,
        int $resolvedBy = 0,
        int $lastEditedBy = 0,
        int $duplicateBugIds = 0,
        int $originalBugId = 0
    ) {
        $this->id = $id;
        $this->parentId = $parentId;
        $this->title = $title;
        $this->status = $status;
        $this->priority = $priority;
        $this->customer = $customer;
        $this->person = $person;
        $this->ticketNumber = $ticketNumber;
        $this->opened = $opened;
        $this->replied = $replied;
        $this->summary = $summary;
        $this->timeEstimate = $timeEstimate;
        $this->openedBy = $openedBy;
        $this->closedBy = $closedBy;
        $this->resolvedBy = $resolvedBy;
        $this->lastEditedBy = $lastEditedBy;
        $this->duplicateBugIds = $duplicateBugIds;
        $this->originalBugId = $originalBugId;

        parent::__construct();
    }

    public function id() : int
    {
        return $this->id;
    }

    public function parentId() : int
    {
        return $this->parentId;
    }

    public function title() : string
    {
        return $this->title;
    }

    public function status() : Status
    {
        return $this->status;
    }

    public function priority() : Priority
    {
        return $this->priority;
    }

    public function customer() : Customer
    {
        return $this->customer;
    }

    public function person() : Person
    {
        return $this->person;
    }

    public function ticketNumber() : string
    {
        return $this->ticketNumber;
    }

    public function opened() : bool
    {
        return $this->opened;
    }

    public function replied() : bool
    {
        return $this->replied;
    }

    public function summary() : string
    {
        return $this->summary;
    }

    public function timeEstimate() : int
    {
        return $this->timeEstimate;
    }

    public function openedBy() : int
    {
        return $this->openedBy;
    }

    public function closedBy() : int
    {
        return $this->closedBy;
    }

    public function resolvedBy() : int
    {
        return $this->resolvedBy;
    }

    public function lastEditedBy() : int
    {
        return $this->lastEditedBy;
    }

    public function duplicateBugIds() : int
    {
        return $this->duplicateBugIds;
    }

    public function originalBugId() : int
    {
        return $this->originalBugId;
    }

    public function arrayCopy() : array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'parent_id' => $this->parentId,
            'status' => $this->status->arrayCopy(),
            'priority' => $this->priority->arrayCopy(),
            'customer' => $this->customer->arrayCopy(),
            'person' => $this->person->arrayCopy(),
            'ticket_number' => $this->ticketNumber,
            'opened' => $this->opened,
            'replied' => $this->replied,
            'summary' => $this->summary,
            'time_estimate' => $this->timeEstimate,
            'opened_by' => $this->openedBy,
            'closed_by' => $this->closedBy,
            'resolved_by' => $this->resolvedBy,
            'last_edited_by' => $this->lastEditedBy,
            'duplicate_bug_ids' => $this->duplicateBugIds,
            'original_bug_id' => $this->originalBugId,
        ];
    }

    public static function makeFromArray(array $data) : self
    {
        return new self(
            $data['id'],
            $data['parent_id'],
            $data['title'],
            $data['status'],
            $data['priority'],
            $data['customer'],
            $data['person'],
            $data['ticket_number'],
            $data['opened'],
            $data['replied'],
            $data['summary'],
            $data['time_estimate'],
            $data['opened_by'],
            $data['closed_by'] ?? 0,
            $data['resolved_by'] ?? 0,
            $data['last_edited_by'] ?? 0,
            $data['duplicate_bug_ids'] ?? 0,
            $data['original_bug_id'] ?? 0
        );
    }
}
