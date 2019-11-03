<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Project;

use Amesplash\FogBugzApi\Foundation\Entity;
use Amesplash\FogBugzApi\Column\Person;

final class Project extends Entity
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var Person */
    private $person;

    /** @var bool */
    private $isInbox;

    /** @var int */
    private $workflowId;

    /** @var bool */
    private $isSoftDeleted;

    /** @var string */
    private $publicEmailAddress;

    public function __construct(
        int $id,
        string $name,
        Person $person,
        bool $isInbox,
        int $workflowId,
        bool $isSoftDeleted,
        string $publicEmailAddress = ''
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->person = $person;
        $this->isInbox = $isInbox;
        $this->workflowId = $workflowId;
        $this->isSoftDeleted = $isSoftDeleted;
        $this->publicEmailAddress = $publicEmailAddress;

        parent::__construct();
    }

    public function id() : int
    {
        return $this->id;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function person() : Person
    {
        return $this->person;
    }

    public function isInbox() : bool
    {
        return $this->isInbox;
    }

    public function workflowId() : int
    {
        return $this->workflowId;
    }

    public function isSoftDeleted() : bool
    {
        return $this->isSoftDeleted;
    }

    public function publicEmailAddress() : string
    {
        return $this->publicEmailAddress;
    }

    public function arrayCopy() : array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'person' => $this->person->arrayCopy(),
            'is_inbox' => $this->isInbox,
            'workflow_id' => $this->workflowId,
            'is_soft_deleted' => $this->isSoftDeleted,
            'public_email_address' => $this->publicEmailAddress,
        ];
    }

    public static function makeFromArray(array $data) : self
    {
        return new self(
            $data['id'],
            $data['name'],
            $data['person'],
            $data['is_inbox'],
            $data['workflow_id'],
            $data['is_soft_deleted'],
            $data['public_email_address']
        );
    }
}
