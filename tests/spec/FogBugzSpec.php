<?php

declare(strict_types=1);

namespace spec\Amesplash\FogBugzApi;

use Amesplash\FogBugzApi\FogBugz;
use Amesplash\FogBugzApi\Foundation\Contract\FogBugzHttp;
use Amesplash\FogBugzApi\Invoice\InvoiceApi;
use PhpSpec\ObjectBehavior;

class FogBugzSpec extends ObjectBehavior
{
    public function let(FogBugzHttp $fogBugzHttp)
    {
        $this->beConstructedWith($fogBugzHttp);
    }

    public function it_is_initializable() : void
    {
        $this->shouldBeAnInstanceOf(FogBugz::class);
    }

    public function it_returns_the_invoice_api_instance()
    {
        $this->invoices()->shouldReturnAnInstanceOf(InvoiceApi::class);
    }
}
