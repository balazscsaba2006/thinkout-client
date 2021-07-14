<?php

declare(strict_types = 1);

namespace ThinkOut\Tests;

use PHPUnit\Framework\TestCase;
use ThinkOut\ThinkOutException;

class ThinkOutExceptionTest extends TestCase
{
    public function testExceptionThrowable(): void
    {
        $this->expectException(ThinkOutException::class);
        $this->expectExceptionMessage('Some message.');

        throw new ThinkOutException('Some message.');
    }
}
