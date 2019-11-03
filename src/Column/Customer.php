<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Column;

use Amesplash\FogBugzApi\Foundation\Entity;

final class Customer extends Entity
{
    /** @var string */
    private $name;

    /** @var string */
    private $emailAddress;

    /** @var string */
    private $label;

    /**
     * Creates a new Status instance.
     */
    public function __construct(
        string $name,
        string $emailAddress,
        string $label
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->emailAddress = $emailAddress;

        parent::__construct();
    }

    public function name() : string
    {
        return $this->name;
    }

    public function emailAddress() : string
    {
        return $this->emailAddress;
    }

    public function label() : string
    {
        return $this->label;
    }

    public function arrayCopy() : array
    {
        return [
            'name' => $this->name,
            'email_address' => $this->emailAddress,
            'label' => $this->label,
        ];
    }

    public static function makeFromArray(array $data) : self
    {
        return new self(
            $data['name'],
            $data['email_address'],
            $data['label']
        );
    }
}
