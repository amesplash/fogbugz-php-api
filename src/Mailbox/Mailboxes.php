<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Mailbox;

use Amesplash\FogBugzApi\Foundation\Collection\ArrayCollection;

final class Mailboxes extends ArrayCollection
{
    public function __construct(Mailbox ...$mailbox)
    {
        parent::__construct($mailbox);
    }
}
