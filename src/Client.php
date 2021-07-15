<?php

declare(strict_types = 1);

namespace ThinkOut;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use ThinkOut\Auth\AuthenticatorInterface;
use ThinkOut\Response\Account;
use ThinkOut\Response\Category;
use ThinkOut\Response\Currency;
use ThinkOut\Response\Prediction;
use ThinkOut\Response\ResponseInterface;
use ThinkOut\Response\Transaction;

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

    /**
     * @param array<string, mixed> $queryParams
     *
     * @throws GuzzleException|ThinkOutException
     *
     * @return ResponseInterface|array<ResponseInterface>
     */
    public function getTransactions(array $queryParams = [])
    {
        $allowedKeys = ['start', 'end', 'accountIds', 'categoryIds', 'type'];
        $response = $this->get('transactions', [
            'query' => RequestHelper::prepareParameters($queryParams, $allowedKeys),
        ]);

        return $this->handleResponse($response, Transaction::class . '[]');
    }

    /**
     * @param array<string, mixed> $queryParams
     *
     * @throws GuzzleException|ThinkOutException
     *
     * @return ResponseInterface|array<ResponseInterface>
     */
    public function getPredictions(array $queryParams = [])
    {
        $allowedKeys = ['start', 'end', 'categoryIds', 'currencyIds', 'type', 'statuses', 'onlyOverdue'];
        $response = $this->get('predictions', [
            'query' => RequestHelper::prepareParameters($queryParams, $allowedKeys),
        ]);

        return $this->handleResponse($response, Prediction::class . '[]');
    }
}
