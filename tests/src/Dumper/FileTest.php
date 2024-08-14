<?php

declare(strict_types=1);

namespace Tests\ChiTeck\Stopwatch\Dumper;

use ChiTeck\Stopwatch\Contract\FormatterInterface;
use ChiTeck\Stopwatch\Data\Report;
use ChiTeck\Stopwatch\Dumper\File;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tests\ChiTeck\Stopwatch\Fixture\ReportSet;

/**
 * {@selfdoc}
 */
#[CoversClass(File::class)]
final class FileTest extends TestCase
{
    /**
     * {@selfdoc}
     */
    public function testDumper(): void
    {
        $filename = self::getFilename();
        self::assertFileDoesNotExist($filename);

        // append = true
        $dumper = new File(self::buildFormatter(), $filename, true);
        $dumper->dump(ReportSet::ALPHA->build());
        self::assertSame(ReportSet::ALPHA->hash() . \PHP_EOL, \file_get_contents($filename));
        $dumper->dump(ReportSet::BETA->build());
        self::assertSame(ReportSet::ALPHA->hash() . \PHP_EOL . ReportSet::BETA->hash() . \PHP_EOL, \file_get_contents($filename));

        // append = false
        $dumper = new File(self::buildFormatter(), $filename, false);
        $dumper->dump(ReportSet::ALPHA->build());
        self::assertSame(ReportSet::ALPHA->hash() . \PHP_EOL, \file_get_contents($filename));
        $dumper->dump(ReportSet::BETA->build());
        self::assertSame(ReportSet::BETA->hash() . \PHP_EOL, \file_get_contents($filename));
    }

    /**
     * {@selfdoc}
     */
    public function testException(): void
    {
        $dumper = new File(self::buildFormatter(), 'wrong_scheme://filename');

        self::expectExceptionObject(new \RuntimeException('Could not write to wrong_scheme://filename file'));
        $dumper->dump(ReportSet::ALPHA->build());
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        $filename = self::getFilename();
        if (\file_exists($filename)) {
            \unlink($filename);
        }
    }

    /**
     * {@selfdoc}
     */
    private static function getFilename(): string
    {
        return \sys_get_temp_dir() . '/stopwatch_test_' . $_SERVER['REQUEST_TIME_FLOAT'];
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
}
