<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Status;

use Amesplash\FogBugzApi\Foundation\ApiRequest;
use function array_map;

final class StatusApi extends ApiRequest
{
    public function fetchAll(array $parameters = []) : Statuses
    {
        $data = $this->post('listStatuses', $parameters);

        return new Statuses(...array_map(function ($status) {
            return $this->makeStatusModel($status);
        }, $data['data']['statuses']));
    }

    public function fetchAllResolved() : Statuses
    {
        return $this->fetchAll(['fResolved' => true]);
    }

    public function fetchAllByCategoryId(int $id) : Statuses
    {
        return $this->fetchAll(['ixCategory' => $id]);
    }

    private function makeStatusModel(array $data) : Status
    {
        $data['id'] = $data['ixStatus'];
        $data['label'] = $data['sStatus'];
        $data['category_id'] = $data['ixCategory'];
        $data['for_work_done'] = $data['fWorkDone'];
        $data['for_resolved'] = $data['fResolved'];
        $data['for_duplicate'] = $data['fDuplicate'];
        $data['for_deleted'] = $data['fDeleted'];
        $data['for_reactivate'] = $data['fReactivate'];
        $data['order'] = $data['iOrder'];

        return Status::makeFromArray($data);
    }
}
