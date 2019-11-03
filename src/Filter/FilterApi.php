<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Filter;

use Amesplash\FogBugzApi\Foundation\ApiRequest;
use function array_map;

final class FilterApi extends ApiRequest
{
    public function fetchAll() : Filters
    {
        $data = $this->post('listFilters');
        unset($data['data']['filters'][0]);

        return new Filters(...array_map(function ($filter) {
            return $this->makeFilterModel($filter);
        }, $data['data']['filters']));
    }

    public function useFilter(Filter $filter) : bool
    {
        $data = $this->post('setCurrentFilter', ['sFilter' => $filter]);

        return true;
    }

    public function resetFilter() : bool
    {
        $data = $this->post('setCurrentFilter', ['sFilter' => 'ez']);

        return true;
    }

    private function makeFilterModel(array $data) : Filter
    {
        $data['name'] = $data['sFilter'];
        $data['label'] = $data['#cdata-section'] ?? $data['#text'];
        $data['type'] = $data['type'];

        return Filter::makeFromArray($data);
    }
}
