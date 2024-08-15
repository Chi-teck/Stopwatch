<?php

declare(strict_types=1);

namespace Tests\ChiTeck\Stopwatch\Dumper;

use ChiTeck\Stopwatch\Contract\FormatterInterface;
use ChiTeck\Stopwatch\Data\Report;
use ChiTeck\Stopwatch\Dumper\Buffered;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tests\ChiTeck\Stopwatch\Fixture\ReportSet;

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
        $formatter = new class implements FormatterInterface {
            public function format(Report $report): string
            {
                return \print_r($report, true);
            }
        };
        $dumper = new Buffered($formatter);
        self::assertSame('', $dumper->fetch());
        $dumper->dump(ReportSet::ALPHA->get());
        self::assertSame(\print_r(ReportSet::ALPHA->get(), true), \print_r($dumper->fetch(), true));
        self::assertSame('', $dumper->fetch());
    }
}
