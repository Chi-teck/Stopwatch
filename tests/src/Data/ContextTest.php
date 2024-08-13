<?php

declare(strict_types=1);

namespace Tests\ChiTeck\Stopwatch\Data;

use ChiTeck\Stopwatch\Data\Context;
use PHPUnit\Framework\TestCase;

/**
 * {@selfdoc}
 */
final class ContextTest extends TestCase
{
    /**
     * {@selfdoc}
     */
    public function testConstructor(): void
    {
        $created_at = new \DateTimeImmutable('2023-02-12 18:35:34+00:00');
        $context = new Context('abc', 'Example', $created_at);
        $this->assertSame('abc', $context->id);
        $this->assertSame('Example', $context->label);
        $this->assertSame($created_at, $context->createdAt);
    }

    /**
     * {@selfdoc}
     */
    public function testJsonSerialize(): void
    {
        $created_at =new \DateTimeImmutable('2023-02-12 18:35:34+00:00');
        $context = new Context('abc', 'Example', $created_at);
        self::assertSame('{"id":"abc","label":"Example","createdAt":"2023-02-12T18:35:34+00:00"}', \json_encode($context));
    }
}

