<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi;

use Amesplash\FogBugzApi\Foundation\Contract\FogBugzHttp as HttpContract;
use Amesplash\FogBugzApi\Foundation\Contract\HttpFactory;
use Amesplash\FogBugzApi\Foundation\Exception\ApiRateLimitExceeded;
use Amesplash\FogBugzApi\Foundation\Exception\JsonError;
use Amesplash\FogBugzApi\Foundation\Exception\NotFound;
use Amesplash\FogBugzApi\Foundation\Exception\RequestError;
use Amesplash\FogBugzApi\Foundation\Exception\ServerError;
use Amesplash\FogBugzApi\Foundation\Exception\Unauthorized;
use Amesplash\FogBugzApi\Foundation\Exception\UnprocessableEntity;
use Psr\Http\Client\ClientInterface as HttpClient;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\UriInterface as Uri;
use const JSON_ERROR_NONE;
use const PHP_MAJOR_VERSION;
use const PHP_MINOR_VERSION;
use function array_merge;
use function http_build_query;
use function implode;
use function json_decode;
use function json_encode;
use function json_last_error;
use function json_last_error_msg;
use function strpos;

final class FogBugzHttp implements HttpContract
{
    public const VERSION = '0.1.0';

    /** @var string */
    private $apiToken;

    /** @var string */
    private $baseUri;

    /** @var HttpClient */
    private $httpClient;

    /** @var HttpFactory */
    private $httpFactory;

    /** @var array */
    private $errorCodes = [

    ];

    /**
     * Create new FogBugz Http instance
     */
    public function __construct(
        string $apiToken,
        string $accountUri,
        HttpClient $httpClient,
        HttpFactory $httpFactory
    ) {
        $this->apiToken = $apiToken;
        $this->baseUri = 'https://' . $accountUri . '/api/';
        $this->httpClient = $httpClient;
        $this->httpFactory = $httpFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function send(Request $request) : Response
    {
        $userAgent = [
            'amesplash/fogbugz-php-api-' . self::VERSION,
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

        return $this->checkResponse($this->httpClient->sendRequest($request));
    }

    /**
     * {@inheritdoc}
     */
    public function post(
        string $uri,
        array $data = []
    ) : Response {
        $preparedUri = $this->makeUri($uri);

        $request = $this->httpFactory->createRequest('POST', $preparedUri);
        $data = array_merge($data, ['token' => $this->apiToken]);

        if (! empty($data)) {
            $encodedData = $this->jsonEncodeData($data);
            $stream = $this->httpFactory->createStream($encodedData);
            $request = $request->withBody($stream);
        }

        return $this->send($request);
    }

    public function decodeResponseBody(Response $response) : array
    {
        if ($response->getBody()->isSeekable()) {
            $response->getBody()->rewind();
        }

        return $this->decodeJsonData($response->getBody()->getContents());
    }

    private function makeUri(string $uri, array $params = []) : Uri
    {
        $preparedUri = $this->httpFactory->createUri($this->baseUri . $uri);

        if (! empty($params)) {
            $preparedUri = $preparedUri->withQuery(http_build_query($params));
        }

        return $preparedUri;
    }

    private function jsonEncodeData(array $data) : string
    {
        $encodedData = (string) json_encode($data);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw JsonError::whenEncoding($data, json_last_error_msg());
        }

        return $encodedData;
    }

    private function decodeJsonData(string $jsonString) : array
    {
        $decodeData = (array) json_decode($jsonString, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw JsonError::whenDecoding($jsonString, json_last_error_msg());
        }

        return $decodeData;
    }

    private function checkResponse(Response $response) : Response
    {
        $statusCode = $response->getStatusCode();

        if ($response->getBody()->isSeekable()) {
            $response->getBody()->rewind();
        }

        $statusCodeType = (int) ($statusCode / 100);

        if ($statusCodeType === 2) {
            return $response;
        }

        $body = $this->decodeResponseBody($response);

        $errorMessage = $body['errors'][0]['message'];

        // If it's a 5xx error, throw Server exception
        if ($statusCodeType === 5) {
            throw ServerError::withMessage($errorMessage, $statusCode);
        }

        if (
            $statusCode === 401
            || strpos('Error 3:', $errorMessage) !== false
        ) {
            throw Unauthorized::attempt();
        }

        if (
            $statusCode === 403
            || strpos('Error 13:', $errorMessage) !== false
            || strpos('Error 8:', $errorMessage) !== false
        ) {
            throw Unauthorized::request();
        }

        if (
            $statusCode === 404
            || strpos('Error 17:', $errorMessage) !== false
            || strpos('Error 18:', $errorMessage) !== false
            || strpos('Error 27:', $errorMessage) !== false
        ) {
            throw new NotFound($errorMessage ?? 'Not Found');
        }

        if (
            $statusCode === 422
            || strpos('Error 19:', $errorMessage) !== false
            || strpos('Error 20:', $errorMessage) !== false
            || strpos('Error 21:', $errorMessage) !== false
            || strpos('Error 22:', $errorMessage) !== false
        ) {
            throw new UnprocessableEntity($errorMessage ?? 'Valdidation Error');
        }

        if ($statusCode === 429) {
            throw new ApiRateLimitExceeded();
        }

        throw new RequestError($errorMessage, $statusCode);
    }
}
