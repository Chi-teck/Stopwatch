<?php

declare(strict_types=1);

namespace Tests\ChiTeck\Stopwatch\Dumper;

use ChiTeck\Stopwatch\Contract\FormatterInterface;
use ChiTeck\Stopwatch\Data\Context;
use ChiTeck\Stopwatch\Data\Report;
use ChiTeck\Stopwatch\Data\Tick;
use ChiTeck\Stopwatch\Dumper\Buffered;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * {@selfdoc}
 */
#[CoversClass(Buffered::class)]
final class BufferedTest extends TestCase
{
    /**
     * {@selfdoc}
     */
    public function testDumper(): void
    {
        $dumper = new Buffered(self::buildFormatter());
        self::assertSame('', $dumper->fetch());
        $dumper->dump(self::buildReport());
        self::assertSame('86b1a90c79b340057681d6d25fbd6143', $dumper->fetch());
        self::assertSame('', $dumper->fetch());
    }

    /**
     * {@selfdoc}
     */
    private static function buildFormatter(): FormatterInterface
    {
        return new class implements FormatterInterface {
            public function format(Report $report): string
            {
                return \md5(\print_r($report, true));
            }
        };
    }

    /**
     * {@selfdoc}
     */
    private static function buildReport(): Report
    {
        $location = [
            'file' => 'example.php',
            'line' => 10,
            'function' => 'example',
            'class' => __CLASS__,
            'type' => '->',
        ];
        return new Report(
            new Context('123', 'Test', new \DateTimeImmutable('2024-04-12')),
            [new Tick('Tick #1', 12345, 123, $location, ['abc'])],
        );
    }
}
