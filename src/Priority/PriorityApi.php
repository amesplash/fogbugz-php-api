<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Priority;

use Amesplash\FogBugzApi\Foundation\ApiRequest;
use function array_map;

final class PriorityApi extends ApiRequest
{
    public function fetchAll() : Priorities
    {
        $data = $this->post('listPriorities');

        return new Priorities(...array_map(function ($priority) {
            return $this->makePriorityModel($priority);
        }, $data['data']['priorities']));
    }

    public function fetchById(int $id) : ?Priority
    {
        $response = $this->post('viewPriority', ['ixPriority' => $id]);

        return isset($response['data']['priority'])
            ? $this->makePriorityModel($response['data']['priority'])
            : null;
    }

    private function makePriorityModel(array $data) : Priority
    {
        $data['id'] = $data['ixPriority'];
        $data['label'] = $data['sPriority'];
        $data['is_default'] = $data['fDefault'] ?? false;

        return Priority::makeFromArray($data);
    }
}
