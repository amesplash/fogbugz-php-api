<?php

declare(strict_types=1);

namespace spec\Amesplash\FogBugzApi;

use Amesplash\FogBugzApi\FogBugzHttp;
use Amesplash\FogBugzApi\Foundation\Contract\FogBugzHttp as HttpContract;
use Amesplash\FogBugzApi\Foundation\Contract\HttpFactory;
use Amesplash\FogBugzApi\Foundation\Exception\ApiRateLimitExceeded;
use Amesplash\FogBugzApi\Foundation\Exception\NotFound;
use Amesplash\FogBugzApi\Foundation\Exception\RequestError;
use Amesplash\FogBugzApi\Foundation\Exception\ServerError;
use Amesplash\FogBugzApi\Foundation\Exception\Unauthorized;
use Psr\Http\Client\ClientInterface as HttpClient;
use function http_build_query;
use function json_encode;

class FogBugzHttpSpec extends TestObjectBehavior
{
    public function let(
        HttpClient $httpClient,
        HttpFactory $httpFactory
    ) {
        $this->beConstructedWith('api-key', $httpClient, $httpFactory);
    }

    public function it_is_initializable() : void
    {
        $this->shouldBeAnInstanceOf(FogBugzHttp::class);
        $this->shouldImplement(HttpContract::class);
    }

    public function it_can_send_a_request(
        HttpClient $httpClient,
        HttpFactory $httpFactory
    ) {
        $response = $this->makeExpectedResponse('empty');
        $request = $this->makeRequest('GET', 'https://test.local');

        $httpClient->sendRequest($request)->willReturn($response);
        $this->send($request);

        $httpClient->sendRequest($request)->shouldHaveBeenCalledOnce();
    }

    public function it_can_prepare_and_send_a_post_request(
        HttpClient $httpClient,
        HttpFactory $httpFactory
    ) {
        // Prepare basic data and expected Response
        $endpoint = $this->baseUri;
        $url = 'clients';
        $data = [
            'name' => 'SublimeText3 Is Awesome Ltd',
            'currency' => 'GBP',
        ];
        $uri = $this->makeUri('clients');
        $stream = $this->makeJsonStreamBody($data);
        $request = $this->makeRequest('POST', $endpoint . $url);
        $response = $this->makeExpectedResponse('client-new');

        // Preset expected return values
        $httpFactory->createStream(json_encode($data))->willReturn($stream);
        $httpFactory->createUri($endpoint . $url)->willReturn($uri);
        $httpFactory->createRequest('POST', $endpoint . $url)
            ->willReturn($request);

        $request = $request->withBody($stream);
        $httpClient->sendRequest($request)->willReturn($response);

        // Ensure everything works smoothly
        $this->post($url, $data)
            ->getBody()
            ->getContents()
            ->shouldBeLike((string) $response->getBody());
    }

    public function it_can_throw_an_server_error_exception(
        HttpClient $httpClient,
        HttpFactory $httpFactory
    ) {
        $response = $this->makeExpectedResponse('error-500', 500);
        $request = $this->makeRequest('GET', 'https://test.local');

        $httpClient->sendRequest($request)->willReturn($response);
        $this->shouldthrow(ServerError::class)->duringSend($request);

        $httpClient->sendRequest($request)->shouldHaveBeenCalledOnce();
    }

    public function it_can_throw_a_not_found_exception(
        HttpClient $httpClient,
        HttpFactory $httpFactory
    ) {
        $response = $this->makeExpectedResponse('error-404', 404);
        $request = $this->makeRequest('GET', 'https://test.local/clients/343');

        $httpClient->sendRequest($request)->willReturn($response);
        $this->shouldthrow(NotFound::class)->duringSend($request);

        $httpClient->sendRequest($request)->shouldHaveBeenCalledOnce();
    }

    public function it_can_throw_an_unauthorized_attempt_exception(
        HttpClient $httpClient,
        HttpFactory $httpFactory
    ) {
        $response = $this->makeExpectedResponse('error-401', 401);
        $request = $this->makeRequest('GET', 'https://test.local/company');

        $httpClient->sendRequest($request)->willReturn($response);
        $this->shouldThrow(Unauthorized::attempt())->duringSend($request);

        $httpClient->sendRequest($request)->shouldHaveBeenCalledOnce();
    }

    public function it_can_throw_an_unauthorized_request_exception(
        HttpClient $httpClient,
        HttpFactory $httpFactory
    ) {
        $response = $this->makeExpectedResponse('error-403', 403);
        $request = $this->makeRequest('GET', 'https://test.local/company');

        $httpClient->sendRequest($request)->willReturn($response);
        $this->shouldThrow(Unauthorized::request())->duringSend($request);

        $httpClient->sendRequest($request)->shouldHaveBeenCalledOnce();
    }

    public function it_can_throw_a_rate_limit_exceeded_exception(
        HttpClient $httpClient,
        HttpFactory $httpFactory
    ) {
        $response = $this->makeExpectedResponse('error-429', 429);
        $request = $this->makeRequest('GET', 'https://test.local/company');

        $httpClient->sendRequest($request)->willReturn($response);
        $this->shouldThrow(ApiRateLimitExceeded::class)->duringSend($request);

        $httpClient->sendRequest($request)->shouldHaveBeenCalledOnce();
    }

    public function it_can_throw_a_request_exception(
        HttpClient $httpClient,
        HttpFactory $httpFactory
    ) {
        $response = $this->makeExpectedResponse('error-request', 412);
        $request = $this->makeRequest('GET', 'https://test.local/company');

        $httpClient->sendRequest($request)->willReturn($response);
        $this->shouldThrow(RequestError::class)->duringSend($request);

        $httpClient->sendRequest($request)->shouldHaveBeenCalledOnce();
    }
}
