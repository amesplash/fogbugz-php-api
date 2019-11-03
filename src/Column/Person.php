<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Column;

use Amesplash\FogBugzApi\Foundation\Entity;

final class Person extends Entity
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var ?string */
    private $emailAddress;

    /** @var ?string */
    private $contactNumber;

    /**
     * Creates a new Status instance.
     */
    public function __construct(
        int $id,
        string $name,
        ?string $emailAddress = null,
        ?string $contactNumber = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->emailAddress = $emailAddress;
        $this->contactNumber = $contactNumber;

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

    public function emailAddress() : ?string
    {
        return $this->emailAddress;
    }

    public function contactNumber() : ?string
    {
        return $this->contactNumber;
    }

    public function arrayCopy() : array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email_address' => $this->emailAddress,
            'contact_number' => $this->contactNumber,
        ];
    }

    public static function makeFromArray(array $data) : self
    {
        return new self(
            $data['id'],
            $data['name'],
            $data['email_address'] ?? null,
            $data['contact_number'] ?? null,
        );
    }
}
