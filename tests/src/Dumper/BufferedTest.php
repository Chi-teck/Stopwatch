<?php

declare(strict_types=1);

namespace Tests\ChiTeck\Stopwatch\Dumper;

use ChiTeck\Stopwatch\Contract\FormatterInterface;
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
        self::assertSame('692ec83590836490ed624a5a54f3b1d7', $dumper->fetch());
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
            id: '123',
            label: 'Test',
            createdAt: new \DateTimeImmutable('2024-04-12'),
            ticks: [new Tick('Tick #1', 12345, 123, $location, ['abc'])],
        );
    }
}
