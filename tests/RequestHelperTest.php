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
use ThinkOut\RequestHelper;
use ThinkOut\Response\Account;
use ThinkOut\Response\Category;
use ThinkOut\Response\Currency;
use ThinkOut\Response\SignInData;
use ThinkOut\Response\Transaction;
use Webmozart\Assert\Assert;

class RequestHelperTest extends TestCase
{
    public function testPrepareParameters(): void
    {
        $allowedKeys = ['start', 'end', 'accountIds', 'categoryIds', 'type'];

        $prepared = RequestHelper::prepareParameters([
            'start' => new \DateTime('2020-10-01'),
            'end' => new \DateTime('2020-12-31'),
            'accountIds' => ['accountIdOne', 'accountIdTwo'],
            'categoryIds' => ['categoryIdOne', 'categoryIdTwo'],
            'type' => false,
            'unallowed_key' => 'value',
        ], $allowedKeys);

        self::assertCount(5, $prepared);
        self::assertEquals('2020-10-01', $prepared['start']);
        self::assertEquals('2020-12-31', $prepared['end']);
        self::assertSame(['accountIdOne', 'accountIdTwo'], $prepared['accountIds']);
        self::assertSame(['categoryIdOne', 'categoryIdTwo'], $prepared['categoryIds']);
        self::assertSame(0, $prepared['type']);
    }
}
