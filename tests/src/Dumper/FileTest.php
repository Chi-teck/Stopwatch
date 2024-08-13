<?php

declare(strict_types=1);

namespace Tests\ChiTeck\Stopwatch\Dumper;

use ChiTeck\Stopwatch\Contract\FormatterInterface;
use ChiTeck\Stopwatch\Data\Context;
use ChiTeck\Stopwatch\Data\Report;
use ChiTeck\Stopwatch\Data\Tick;
use ChiTeck\Stopwatch\Dumper\File;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

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
        $dumper = new File(self::buildFormatter(), $filename);

        $dumper->dump(self::buildReport());
        self::assertSame('889e5be91835a2ed060de4a3cf079e00', \file_get_contents($filename));
    }

    /**
     * {@selfdoc}
     */
    public function testException(): void
    {
        $dumper = new File(self::buildFormatter(), 'wrong_scheme://filename');

        self::expectExceptionObject(new \RuntimeException('Could not write to wrong_scheme://filename file'));
        $dumper->dump(self::buildReport());
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
        return \sys_get_temp_dir() . '/stopwatch_test_' . $_SERVER['REQUEST_TIME_FLOAT'] . '.json';
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
