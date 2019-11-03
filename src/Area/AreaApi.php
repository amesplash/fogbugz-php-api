<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Area;

use Amesplash\FogBugzApi\Column\AreaType;
use Amesplash\FogBugzApi\Column\Person;
use Amesplash\FogBugzApi\Column\Project;
use Amesplash\FogBugzApi\Foundation\ApiRequest;
use function array_map;

final class AreaApi extends ApiRequest
{
    public function fetchAll(array $query = []) : Areas
    {
        $response = $this->post('listAreas', $query);

        return new Areas(...array_map(function ($area) {
            return $this->makeAreaModel($area);
        }, $response['data']['areas']));
    }

    public function fetchById(int $id) : ?Area
    {
        $areas = $this->fetchAll();

        return $areas->filter(static function ($area) use ($id) {
            return $area->id() === $id;
        })->first();
    }

    public function fetchByProjectId(int $id) : ?Area
    {
        $areas = $this->fetchAll(['ixProject' => $id]);

        return $areas->filter(static function ($area) use ($id) {
            return $area->id() === $id;
        })->first();
    }

    public function create(int $id) : ?Area
    {
        $areas = $this->fetchAll();

        return $areas->filter(static function ($area) use ($id) {
            return $area->id() === $id;
        })->first();
    }

    private function makeAreaModel(array $data) : Area
    {
        $data['id'] = $data['ixArea'];
        $data['name'] = $data['sArea'];
        $data['total_trained_documents'] = $data['cDoc'];
        $data['is_deleted'] = $data['fDeleted'] ?? null;

        $data['person'] = Person::makeFromArray([
            'id' => $data['ixPersonOwner'],
            'name' => $data['sPersonOwner'],
        ]);
        $data['project'] = Project::makeFromArray([
            'id' => $data['ixProject'],
            'name' => $data['sProject'],
        ]);
        $data['type'] = AreaType::makeFromArray([
            'id' => $data['nType'],
        ]);

        return Area::makeFromArray($data);
    }
}
