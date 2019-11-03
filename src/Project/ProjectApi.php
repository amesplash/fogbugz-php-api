<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Project;

use Amesplash\FogBugzApi\Foundation\ApiRequest;
use Amesplash\FogBugzApi\Column\Person;
use function array_map;

final class ProjectApi extends ApiRequest
{
    public function fetchAll() : Projects
    {
        $data = $this->post('listProjects');

        return new Projects(...array_map(function ($project) {
            return $this->makeProjectModel($project);
        }, $data['data']['projects']));
    }

    public function fetchById(int $id) : Project
    {
        $data = $this->post('viewProject', ['ixProject' => $id]);

        return isset($response['data']['project'])
            ? $this->makeProjectModel($response['data']['project'])
            : null;
    }

    private function makeProjectModel(array $data) : Project
    {
        $data['id'] = $data['ixProject'];
        $data['name'] = $data['sProject'];
        $data['is_inbox'] = $data['fInbox'];
        $data['workflow_id'] = $data['ixWorkflow'];
        $data['is_soft_deleted'] = $data['fDeleted'];
        $data['public_email_address'] = $data['sPublicSubmitEmail'];
        
        $data['person'] = Person::makeFromArray([
            'owner_id' => $data['ixPersonOwner'],
            'owner_name' => $data['sPersonOwner'],
            'owner_email_address' => $data['sEmail'],
            'owner_contact_number' => $data['sPhone'],
        ]);

        return Project::makeFromArray($data);
    }
}
