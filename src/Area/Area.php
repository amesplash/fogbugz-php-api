<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Area;

use Amesplash\FogBugzApi\Column\AreaType;
use Amesplash\FogBugzApi\Column\Person;
use Amesplash\FogBugzApi\Column\Project;
use Amesplash\FogBugzApi\Foundation\Entity;

final class Area extends Entity
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var Person */
    private $person;

    /** @var Project */
    private $project;

    /** @var AreaType */
    private $type;

    /** @var int */
    private $totalTrainedDocuments;

    /** @var ?bool */
    private $isDeleted;

    public function __construct(
        int $id,
        string $name,
        Person $person,
        Project $project,
        AreaType $type,
        int $totalTrainedDocuments,
        ?bool $isDeleted = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->person = $person;
        $this->project = $project;
        $this->type = $type;
        $this->totalTrainedDocuments = $totalTrainedDocuments;
        $this->isDeleted = $isDeleted;

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

    public function project() : Project
    {
        return $this->project;
    }

    public function type() : AreaType
    {
        return $this->type;
    }

    public function totalTrainedDocuments() : int
    {
        return $this->totalTrainedDocuments;
    }

    public function isDeleted() : ?bool
    {
        return $this->isDeleted;
    }

    public function arrayCopy() : array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'person' => $this->person->arrayCopy(),
            'project' => $this->project->arrayCopy(),
            'type' => $this->type->arrayCopy(),
            'total_trained_documents' => $this->totalTrainedDocuments,
            'is_deleted' => $this->isDeleted,
        ];
    }

    public static function makeFromArray(array $data) : self
    {
        return new self(
            $data['id'],
            $data['name'],
            $data['person'],
            $data['project'],
            $data['type'],
            $data['total_trained_documents'],
            $data['is_deleted']
        );
    }
}
