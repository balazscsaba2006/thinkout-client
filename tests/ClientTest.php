<?php

declare(strict_types = 1);

namespace ThinkOut\Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use ThinkOut\Auth\AuthenticatorInterface;
use ThinkOut\Client;
use ThinkOut\Response\Account;
use ThinkOut\Response\Category;
use ThinkOut\Response\Currency;
use ThinkOut\Response\SignInData;
use Webmozart\Assert\Assert;

class ClientTest extends TestCase
{
    private AuthenticatorInterface $authenticator;

    public function setUp(): void
    {
        $signInData = $this->createMock(SignInData::class);
        $signInData
            ->expects(self::once())
            ->method('getToken')
            ->willReturn('token')
        ;
        $this->authenticator = $this->createMock(AuthenticatorInterface::class);
        $this->authenticator
            ->expects(self::once())
            ->method('authenticate')
            ->willReturn($signInData)
        ;

        parent::setUp();
    }

    public function testConfiguration(): void
    {
        $config = $this->createClient()->getConfig();
        $baseUri = $config['base_uri'];
        $headers = $config['headers'];

        $this->assertInstanceOf(Uri::class, $baseUri);
        $this->assertEquals('api.thinkout.io', $baseUri->getHost());
        $this->assertEquals('/api/partners/', $baseUri->getPath());
        $this->assertArrayHasKey('Authorization', $headers);
        $this->assertEquals('Bearer token', $headers['Authorization']);
    }

    public function testGetCurrencies(): void
    {
        $content = $this->loadJsonData('currencies.json');
        $client = $this->createClientWithResponse($content);

        /** @var Currency[] $currencies */
        $currencies = $client->getCurrencies();
        $this->assertCount(6, $currencies);

        $decoded = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        foreach ($currencies as $key => $currency) {
            $this->assertEquals($decoded[$key]['id'], $currency->getId());
            $this->assertEquals($decoded[$key]['name'], $currency->getName());
        }
    }

    public function testGetCategories(): void
    {
        $content = $this->loadJsonData('categories.json');
        $client = $this->createClientWithResponse($content);

        /** @var Category[] $categories */
        $categories = $client->getCategories();
        $this->assertCount(14, $categories);

        $decoded = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        foreach ($categories as $key => $category) {
            $this->assertEquals($decoded[$key]['id'], $category->getId());
            $this->assertEquals($decoded[$key]['name'], $category->getName());
            $this->assertEquals($decoded[$key]['type'], $category->getType());
            $this->assertEquals($decoded[$key]['parentId'], $category->getParentId());

            $children = $decoded[$key]['children'];
            if (null !== $children) {
                $this->assertCount(\count($children), $category->getChildren());
            } else {
                $this->assertNull($category->getChildren());
            }
        }
    }

    public function testGetAccounts(): void
    {
        $content = $this->loadJsonData('accounts.json');
        $client = $this->createClientWithResponse($content);

        /** @var Account[] $accounts */
        $accounts = $client->getAccounts();
        $this->assertCount(4, $accounts);

        $decoded = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        foreach ($accounts as $key => $account) {
            $this->assertEquals($decoded[$key]['id'], $account->getId());
            $this->assertEquals($decoded[$key]['balance'], $account->getBalance());
            $this->assertEquals($decoded[$key]['currency'], $account->getCurrency());
            $this->assertEquals($decoded[$key]['currencyId'], $account->getCurrencyId());
            $this->assertEquals($decoded[$key]['initialBalance'], $account->getInitialBalance());
            $this->assertEquals(new \DateTime($decoded[$key]['initialDateTime']), $account->getInitialDateTime());
            $this->assertEquals($decoded[$key]['name'], $account->getName());
            $this->assertEquals($decoded[$key]['originalName'], $account->getOriginalName());
            $this->assertEquals($decoded[$key]['source'], $account->getSource());
            $this->assertEquals($decoded[$key]['bankName'], $account->getBankName());
        }
    }

    private function loadJsonData(string $filename): string
    {
        $path = sprintf('%s/.data/%s', realpath(__DIR__), $filename);
        $data = file_get_contents($path);
        Assert::string($data);

        return $data;
    }

    /**
     * @param array<string, mixed> $headers
     */
    private function createClientWithResponse(
        string $content,
        int $statusCode = 200,
        array $headers = []
    ): Client {
        $mock = new MockHandler([new Response($statusCode, $headers, $content)]);
        $handlerStack = HandlerStack::create($mock);

        return $this->createClient(['handler' => $handlerStack]);
    }

    /**
     * @param array<string, mixed> $config
     */
    private function createClient(array $config = []): Client
    {
        return new Client($this->authenticator, $config);
    }
}
