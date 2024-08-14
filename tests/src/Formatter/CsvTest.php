<?php

declare(strict_types=1);

namespace Tests\ChiTeck\Stopwatch\Formatter;

use ChiTeck\Stopwatch\Formatter\Csv;
use ChiTeck\Stopwatch\Formatter\Json;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\ChiTeck\Stopwatch\Fixture\ReportSet;

#[CoversClass(Json::class)]
final class CsvTest extends TestCase
{
    #[Test]
    public function outputWithTicks(): void
    {
        $formatter = new Csv();
        $output = $formatter->format(ReportSet::BETA->build());
        $expected_output = <<< 'CSV'
            "Tick #1",0.000,0.000,0.001
            "Tick #2",10000.000,10000.000,0.002
            "Tick #3",20000.000,10000.000,0.003

            CSV;
        self::assertSame($expected_output, $output);
    }

    #[Test]
    public function outputWithoutTicks(): void
    {
        $formatter = new Csv();
        $output = $formatter->format(ReportSet::DELTA->build());
        self::assertSame('', $output);
    }
}
