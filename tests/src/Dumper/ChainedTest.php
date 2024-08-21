<?php

declare(strict_types=1);

namespace Tests\ChiTeck\Stopwatch\Dumper;

use ChiTeck\Stopwatch\Contract\FormatterInterface;
use ChiTeck\Stopwatch\Data\Report;
use ChiTeck\Stopwatch\Dumper\Buffered;
use ChiTeck\Stopwatch\Dumper\Chained;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tests\ChiTeck\Stopwatch\Fixture\ReportSet;

/**
 * {@selfdoc}
 */
#[CoversClass(Chained::class)]
final class ChainedTest extends TestCase
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
        $dumper = new Chained(
            $dumper_1 = new Buffered($formatter),
            $dumper_2 = new Buffered($formatter),
        );

        self::assertSame('', $dumper_1->fetch());
        self::assertSame('', $dumper_2->fetch());

        $dumper->dump(ReportSet::ALPHA->get());

        self::assertSame(
            \print_r(ReportSet::ALPHA->get(), true),
            $dumper_1->fetch(),
        );
        self::assertSame(
            \print_r(ReportSet::ALPHA->get(), true),
            $dumper_2->fetch(),
        );
    }
}
