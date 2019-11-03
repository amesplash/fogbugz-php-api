<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Mailbox;

use Amesplash\FogBugzApi\Foundation\ApiRequest;
use function array_map;

final class MailboxApi extends ApiRequest
{
    public function fetchAll() : Mailboxes
    {
        $data = $this->post('listMailboxes');

        return new Mailboxes(...array_map(function ($mailbox) {
            return $this->makeMailboxModel($mailbox);
        }, $data['data']['mailboxes']));
    }

    public function fetchById(int $id) : ?Mailbox
    {
        $response = $this->post('viewMailbox', ['ixMailbox' => $id]);

        return isset($response['data']['mailbox'])
            ? $this->makeMailboxModel($response['data']['mailbox'])
            : null;
    }

    private function makeMailboxModel(array $data) : Mailbox
    {
        $data['id'] = $data['ixMailbox'];
        $data['email_address'] = $data['sEmail'];
        $data['user_email_address'] = $data['sEmailUser'];
        $data['template'] = $data['sTemplate'];

        return Mailbox::makeFromArray($data);
    }
}
