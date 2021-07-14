<?php

declare(strict_types = 1);

namespace ThinkOut;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use ThinkOut\Auth\AuthenticatorInterface;
use ThinkOut\Response\Account;
use ThinkOut\Response\Category;
use ThinkOut\Response\Currency;
use ThinkOut\Response\ResponseInterface;

class Client extends GuzzleClient
{
    use HelperTrait;

    private const API_URL = 'https://api.thinkout.io/api/partners/';

    /**
     * @param array<string, mixed> $config
     */
    public function __construct(AuthenticatorInterface $authenticator, array $config = [])
    {
        $signInData = $authenticator->authenticate();

        $config['base_uri'] = self::API_URL;
        $config['headers']['Authorization'] = sprintf('Bearer %s', $signInData->getToken());

        parent::__construct($config);
    }

    /**
     * @throws GuzzleException|ThinkOutException
     *
     * @return array<ResponseInterface>
     */
    public function getCurrencies(): array
    {
        $response = $this->get('currencies');

        return $this->handleResponse($response, Currency::class . '[]');
    }

    /**
     * @throws GuzzleException|ThinkOutException
     *
     * @return ResponseInterface|array<ResponseInterface>
     */
    public function getCategories()
    {
        $response = $this->get('categories');

        return $this->handleResponse($response, Category::class . '[]');
    }

    /**
     * @throws GuzzleException|ThinkOutException
     *
     * @return ResponseInterface|array<ResponseInterface>
     */
    public function getAccounts()
    {
        $response = $this->get('accounts');

        return $this->handleResponse($response, Account::class . '[]');
    }
}
