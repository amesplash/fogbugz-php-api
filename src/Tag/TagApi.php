<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Tag;

use Amesplash\FogBugzApi\Foundation\ApiRequest;
use function array_map;

final class TagApi extends ApiRequest
{
    public function fetchAll() : Tags
    {
        $data = $this->post('listTags');

        return new Tags(...array_map(function ($tag) {
            return $this->makeTagModel($tag);
        }, $data['data']['tags']));
    }

    public function fetchById(int $id) : ?Tag
    {
        $tags = $this->fetchAll();

        return $tags->filter(static function ($tag) use ($id) {
            return $tag->id() === $id;
        })->first();
    }

    private function makeTagModel(array $data) : Tag
    {
        $data['id'] = $data['ixTag'];
        $data['label'] = $data['sTag'];
        $data['usage_count'] = $data['cTagUses'];

        return Tag::makeFromArray($data);
    }
}
