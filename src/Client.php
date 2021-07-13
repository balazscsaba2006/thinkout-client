<?php

declare(strict_types = 1);

namespace ThinkOut;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use ThinkOut\Response\Account;
use ThinkOut\Response\Category;
use ThinkOut\Response\Currency;
use ThinkOut\Response\ResponseInterface;
use ThinkOut\Response\SignInData;

class Client extends GuzzleClient
{
    use HelperTrait;

    private const API_URL = 'https://api.thinkout.io/api/partners/';

    private SignInData $signInData;

    /**
     * @param array<string, mixed> $config
     */
    public function __construct(string $username, string $password, array $config = [])
    {
        $this->signInData = (new Authenticator($username, $password))->authenticate();

        $config['base_uri'] = self::API_URL;
        $config['headers']['Authorization'] = sprintf('Bearer %s', $this->signInData->getToken());

        parent::__construct($config);
    }

    /**
     * @throws GuzzleException|ThinkOutException
     *
     * @return ResponseInterface|array<ResponseInterface>
     */
    public function getCurrencies()
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
