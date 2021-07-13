<?php

declare(strict_types = 1);

namespace ThinkOut\Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use ThinkOut\ThinkOutException;

class ThinkOutExceptionTest extends TestCase
{
    public function testInstantiation(): void
    {
        $exception = new ThinkOutException();
        self::assertInstanceOf(ThinkOutException::class, $exception);
        self::assertInstanceOf(Exception::class, $exception);
    }

    public function testExceptionThrowable(): void
    {
        $this->expectException(ThinkOutException::class);
        $this->expectExceptionMessage('Some message.');

        throw new ThinkOutException('Some message.');
    }
}
