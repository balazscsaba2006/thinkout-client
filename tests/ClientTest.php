<?php

declare(strict_types = 1);

namespace ThinkOut\Tests;

use PHPUnit\Framework\TestCase;
use ThinkOut\Client;

class ClientTest extends TestCase
{
    private Client $client;

    public function setUp(): void
    {
        $username = getenv('API_USERNAME') ?: 'username';
        $password = getenv('API_PASSWORD') ?: 'password';
        $this->client = new Client($username, $password);

        parent::setUp();
    }
}
