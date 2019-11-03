<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Mailbox;

use Amesplash\FogBugzApi\Foundation\Entity;

final class Mailbox extends Entity
{
    /** @var int */
    private $id;

    /** @var string */
    private $emailAddress;

    /** @var int */
    private $userEmailAddress;

    /** @var string */
    private $template;

    public function __construct(
        int $id,
        string $emailAddress,
        string $userEmailAddress,
        string $template
    ) {
        $this->id = $id;
        $this->emailAddress = $emailAddress;
        $this->userEmailAddress = $userEmailAddress;
        $this->template = $template;

        parent::__construct();
    }

    public function id() : int
    {
        return $this->id;
    }

    public function emailAddress() : string
    {
        return $this->emailAddress;
    }

    public function userEmailAddress() : string
    {
        return $this->userEmailAddress;
    }

    public function template() : string
    {
        return $this->template;
    }

    public function arrayCopy() : array
    {
        return [
            'id' => $this->id,
            'email_address' => $this->emailAddress,
            'user_email_address' => $this->userEmailAddress,
            'template' => $this->template,
        ];
    }

    public function makeFromArray(array $data) : self
    {
        return new self(
            $data['id'],
            $data['email_address'],
            $data['user_email_address'],
            $data['template']
        );
    }
}
