<?php

declare(strict_types=1);

namespace spec\Amesplash\FogBugzApi;

use Amesplash\FogBugzApi\FogBugzHttp;
use Nyholm\Psr7\Request;
use Nyholm\Psr7\Response;
use Nyholm\Psr7\Stream;
use Nyholm\Psr7\Uri;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;
use function file_get_contents;
use function fopen;
use function implode;
use function json_decode;
use function json_encode;
use function realpath;
use const PHP_MAJOR_VERSION;
use const PHP_MINOR_VERSION;

abstract class TestObjectBehavior extends ObjectBehavior
{
    /** @var string */
    protected $baseUri = 'https://api.fogBugzapp.com/v2/';

    protected function makeRequest(
        string $method,
        string $uri,
        array $params = []
    ) : RequestInterface {
        $request = new Request($method, $uri);

        $userAgent = [
            'amesplash/fogBugz-php-api-' . FogBugzHttp::VERSION,
            'php/' . PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION,
        ];

        $request = $request->withHeader(
            'User-Agent',
            implode(' ', $userAgent)
        );

        $request = $request->withHeader(
            'Content-Type',
            'application/json'
        );

        $request = $request->withHeader(
            'Accept',
            'application/json'
        );

        $request = $request->withHeader('Authorization', 'Bearer: api-key');

        if ($method === 'POST') {
            $request = $request->withBody(
                Stream::create(json_encode($params))
            );
        }

        return $request;
    }

    protected function makeUri(string $uri) : UriInterface
    {
        return new Uri($this->baseUri . $uri);
    }

    protected function makeJsonStreamBody(array $data) : StreamInterface
    {
        return Stream::create((string) json_encode($data));
    }

    /**
     * Get the API response we'd expect for a call to the API.
     */
    protected function makeExpectedResponse(
        string $file,
        int $statusCode = 200
    ) : ResponseInterface {
        return new Response(
            $statusCode,
            [],
            fopen(
                realpath(__DIR__ . '/../fixtures/responses')
                . '/' . $file . '.json',
                'r'
            )
        );
    }

    protected function loadJsonFile(string $file) : string
    {
        return json_decode(file_get_contents(
            realpath(__DIR__ . '/../fixtures/responses')
            . '/' . $file . '.json',
            'r'
        ));
    }
}
