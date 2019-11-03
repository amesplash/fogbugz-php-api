<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Category;

use Amesplash\FogBugzApi\Foundation\ApiRequest;
use function array_map;

final class CategoryApi extends ApiRequest
{
    public function fetchAll() : Categories
    {
        $data = $this->post('listCategories');

        return new Categories(...array_map(function ($case) {
            return $this->makeCategoryModel($case);
        }, $data['data']['categories']));
    }

    public function fetchById(int $id) : ?Category
    {
        $data = $this->post('viewCategory', ['ixCategory' => $id]);

        return isset($data['data']['category'])
            ? $this->makeCategoryModel($data['data']['category'])
            : null;
    }

    private function makeCategoryModel(array $data) : Category
    {
        $data['id'] = $data['ixCategory'];
        $data['label'] = $data['sCategory'];
        $data['plural_label'] = $data['sPlural'];
        $data['default_status_id'] = $data['ixStatusDefault'];
        $data['active_default_status_id'] = $data['ixStatusDefaultActive'];
        $data['for_scheduled_item'] = $data['fIsScheduleItem'];
        $data['for_delete'] = $data['fDeleted'];
        $data['icon_type_id'] = $data['nIconType'];
        $data['attachment_icon_id'] = $data['ixAttachmentIcon'];
        $data['order'] = $data['iOrder'];

        return Category::makeFromArray($data);
    }
}
