<?php

declare(strict_types = 1);

namespace ThinkOut;

use Exception;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Serializer\SerializerInterface;
use ThinkOut\Auth\AuthenticationException;
use ThinkOut\Response\ResponseInterface as ThinkOutResponseInterface;

trait HelperTrait
{
    private SerializerInterface $serializer;

    /**
     * @throws ThinkOutException
     *
     * @return ThinkOutResponseInterface|array<ThinkOutResponseInterface>
     */
    final protected function handleResponse(
        ResponseInterface $response,
        string $responseClass
    ) {
        switch ($response->getStatusCode()) {
            case 200:
                return $this->getSerializer()->deserialize(
                    $response->getBody()->getContents(),
                    $responseClass,
                    'json'
                );
            case 401:
            case 403:
                throw new AuthenticationException('Unable to access the API. Is the API token valid?');
            default:
                throw new ThinkOutException('Unable to process the response.');
        }
    }

    /**
     * @param array<string, int|float|bool|string> $data
     *
     * @throws Exception
     * @return array<string, array<int|float|bool|string>>
     */
    final protected function preparePostData(array $data = []): array
    {
        array_walk_recursive($data, 'trim');

        return array_merge(
            ['headers' => [
                'X-Request-Id' => bin2hex(random_bytes(16)), ],
            ],
            [RequestOptions::JSON => $data]
        );
    }

    private function getSerializer(): SerializerInterface
    {
        return $this->serializer ?? SerializerFactory::create();
    }
}
