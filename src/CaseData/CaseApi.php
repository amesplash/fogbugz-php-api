<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\CaseData;

use Amesplash\FogBugzApi\Column\Area;
use Amesplash\FogBugzApi\Column\Customer;
use Amesplash\FogBugzApi\Column\Person;
use Amesplash\FogBugzApi\Column\Priority;
use Amesplash\FogBugzApi\Column\Project;
use Amesplash\FogBugzApi\Column\Status;
use Amesplash\FogBugzApi\Foundation\ApiRequest;
use Amesplash\FogBugzApi\Foundation\Contract\FogBugzHttp;
use function array_map;
use function array_merge;
use function explode;
use function implode;
use function sprintf;
use function str_replace;
use function trim;

final class CaseApi extends ApiRequest
{
    /** @var FogBugzHttp */
    private $fogBugzHttp;

    /** @var array */
    private $dateElements = [
    ];

    /** @var array */
    private $dateTimeElements = [
        'dtOpened' => 'created_at',
        'dtLastUpdated' => 'updated_at',
        'dtResolved' => 'resolved_at',
        'dtClosed' => 'closed_at',
        'dtDue' => 'due_at',
        'dtLastView' => 'last_viewed_at',
        'dtLastOccurrence' => 'last_occured_at',
    ];

    /** @var array */
    private $defaultColumns = [
        'ixBug',
        'ixBugParent',
        'sStatus',
        'ixStatus',
        'sTitle',
        'hrsCurrEst',
        'sPersonAssignedTo',
        'ixPersonAssignedTo',
        'sEmailAssignedTo',
        'fOpen',
        'sPriority',
        'ixPriority',
        'sCustomerEmail',
        'sTicket',
        'ixPersonOpenedBy',
        'ixPersonResolvedBy',
        'ixPersonClosedBy',
        'ixPersonLastEditedBy',
        'ixBugDuplicates',
        'ixBugOriginal',
        'ixProject',
        'sProject',
        'ixArea',
        'sArea',
        'fReplied',
    ];

    public function fetchAll(array $query = []) : Cases
    {
        $preparedQuery = $this->prepareColumns($query, $this->defaultColumns);

        $response = $this->post('listCases', $preparedQuery);

        return new Cases(...array_map(static function ($case) {
            return $this->makeCaseModel($case);
        }, $response['data']['cases']));
    }

    public function resolve(int $id, array $query) : ?CaseData
    {
        $query = array_merge($query, ['ixBug' => $id]);
        $preparedQuery = $this->prepareColumns($query, $this->defaultColumns);

        $response = $this->fogBugzHttp->post('resolve', $query);
        dd($response);
    }

    /**
     * @param mixed ...$uriParts
     */
    public function makeUri(...$uriParts) : string
    {
        return sprintf('%s/%s', $this->endpoint, implode('/', $uriParts));
    }

    private function makeCaseModel(array $data) : SingleCase
    {
        $data = $this->makeDateColumns($data);

        $data['id'] = $data['ixBug'];
        $data['parent_id'] = $data['ixBugParent'];
        $data['title'] = $data['sTitle'];
        $data['ticket_number'] = $data['sTicket'];
        $data['opened'] = $data['fOpen'];
        $data['replied'] = $data['fReplied'];
        $data['summary'] = $data['sLatestTextSummary'];
        $data['time_estimate'] = $data['hrsCurrEst'];
        $data['opened_by'] = $data['ixPersonOpenedBy'];
        $data['resolved_by'] = $data['ixPersonResolvedBy'];
        $data['closed_by'] = $data['ixPersonClosedBy'];
        $data['last_edited_by'] = $data['ixPersonLastEditedBy'];
        $data['duplicate_bug_ids'] = $data['ixBugDuplicates'];
        $data['original_bug_id'] = $data['ixBugOriginal'];

        $data['person'] = Person::makeFromArray([
            'name' => $data['sPersonAssignedTo'],
            'id' => $data['ixPersonAssignedTo'] ?? null,
            'email_address' => $data['sEmailAssignedTo'] ?? null,
        ]);

        $data['project'] = Project::makeFromArray([
            'id' => $data['ixProject'],
            'name' => $data['sProject'],
        ]);

        $data['area'] = Area::makeFromArray([
            'id' => $data['ixArea'],
            'name' => $data['sArea'],
        ]);

        $data['status'] = Status::makeFromArray([
            'label' => $data['sStatus'] ?? 'Unknown',
            'id' => $data['ixStatus'] ?? 0,
        ]);

        $customer = explode('<', $data['sCustomerEmail'] ?? []);

        $customerEmail = isset($customer[1])
            ? str_replace(['<', '>'], '', $customer[1])
            : str_replace(['<', '>'], '', $customer[0]);
        $customerName = isset($customer[1])
            ? str_replace(['"'], '', $customer[0])
            : '';
        $data['customer'] = Customer::makeFromArray([
            'name' => trim($customerName),
            'email_address' => trim($customerEmail),
            'label' => $data['sCustomerEmail'] ?? 'No Customer attached',
        ]);

        $data['priority'] = Priority::makeFromArray([
            'label' => $data['sPriority'],
            'id' => $data['ixPriority'] ?? null,
        ]);

        return SingleCase::makeFromArray($data);
    }
}
