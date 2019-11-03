<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Foundation;

use Amesplash\FogBugzApi\Foundation\Contract\ApiRequest as ApiRequestContract;
use Amesplash\FogBugzApi\Foundation\Contract\FogBugzHttp;
use DateTimeImmutable;
use DateTimeInterface;
use const ARRAY_FILTER_USE_BOTH;
use function array_filter;
use function array_key_exists;
use function array_merge;
use function implode;
use function is_string;

abstract class ApiRequest implements ApiRequestContract
{
    /** @var FogBugzHttp */
    private $fogBugzHttp;

    /** @var array */
    private $dateTimeColumnMap = [
        'dtOpened' => 'created_at',
        'dtLastUpdated' => 'updated_at',
        'dtResolved' => 'resolved_at',
        'dtClosed' => 'closed_at',
        'dtDue' => 'due_at',
        'dtLastView' => 'last_viewed_at',
        'dtLastOccurrence' => 'last_occured_at',
    ];

    public function __construct(FogBugzHttp $fogBugzHttp)
    {
        $this->fogBugzHttp = $fogBugzHttp;
    }

    public function post(string $uri, array $data = []) : array
    {
        $response = $this->fogBugzHttp->post($uri, $data);

        return $this->fogBugzHttp->decodeResponseBody($response);
    }

    protected function makeDateColumns(array $data) : array
    {
        $dateTimeColumns = array_filter($data, function ($value, $field) {
            return array_key_exists($field, $this->dateTimeColumnMap);
        }, ARRAY_FILTER_USE_BOTH);

        foreach ($dateTimeColumns as $column => $value) {
            $data[$column] =  is_string($value)
                ? DateTimeImmutable::createFromFormat(
                    DateTimeInterface::ISO8601,
                    (string) $value
                )
                : null;
        }

        return $data;
    }

    protected function prepareColumns(
        array $data = [],
        array $defaultColumns = []
    ) : array {
        $columns = $data['cols'] ?? [];
        $data['cols'] = implode(',', array_merge(
            $defaultColumns,
            $columns
        ));

        return $data;
    }
}
