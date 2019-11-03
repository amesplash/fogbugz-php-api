<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi;

use Amesplash\FogBugzApi\Area\AreaApi;
use Amesplash\FogBugzApi\CaseData\CaseApi;
use Amesplash\FogBugzApi\Category\CategoryApi;
use Amesplash\FogBugzApi\Filter\FilterApi;
use Amesplash\FogBugzApi\Foundation\Contract\FogBugzHttp;
use Amesplash\FogBugzApi\Mailbox\MailboxApi;
use Amesplash\FogBugzApi\Priority\PriorityApi;
use Amesplash\FogBugzApi\Status\StatusApi;
use Amesplash\FogBugzApi\Tag\TagApi;

final class FogBugz
{
    /** @var FogBugzHttp */
    private $http;

    /** @var CaseApi */
    private $caseApi;

    /** @var TagApi */
    private $tagApi;

    /** @var StatusApi */
    private $statusApi;

    /** @var Category */
    private $categoryApi;

    /** @var PriorityApi */
    private $priorityApi;

    /** @var MailboxApi */
    private $mailboxApi;

    /** @var FilterApi */
    private $filterApi;

    /** @var AreaApi */
    private $areaApi;

    /**
     * Create new Client instance
     */
    public function __construct(FogBugzHttp $http)
    {
        $this->http = $http;
    }

    public function cases() : CaseApi
    {
        if (! $this->caseApi instanceof CaseApi) {
            $this->caseApi = new CaseApi($this->http);
        }

        return $this->caseApi;
    }

    public function tags() : TagApi
    {
        if (! $this->tagApi instanceof TagApi) {
            $this->tagApi = new TagApi($this->http);
        }

        return $this->tagApi;
    }

    public function statuses() : StatusApi
    {
        if (! $this->statusApi instanceof StatusApi) {
            $this->statusApi = new StatusApi($this->http);
        }

        return $this->statusApi;
    }

    public function categories() : CategoryApi
    {
        if (! $this->categoryApi instanceof CategoryApi) {
            $this->categoryApi = new CategoryApi($this->http);
        }

        return $this->categoryApi;
    }

    public function priorities() : PriorityApi
    {
        if (! $this->priorityApi instanceof PriorityApi) {
            $this->priorityApi = new PriorityApi($this->http);
        }

        return $this->priorityApi;
    }

    public function mailboxes() : MailboxApi
    {
        if (! $this->mailboxApi instanceof MailboxApi) {
            $this->mailboxApi = new MailboxApi($this->http);
        }

        return $this->mailboxApi;
    }

    public function filters() : FilterApi
    {
        if (! $this->filterApi instanceof FilterApi) {
            $this->filterApi = new FilterApi($this->http);
        }

        return $this->filterApi;
    }

    public function areas() : AreaApi
    {
        if (! $this->areaApi instanceof AreaApi) {
            $this->areaApi = new AreaApi($this->http);
        }

        return $this->areaApi;
    }
}
