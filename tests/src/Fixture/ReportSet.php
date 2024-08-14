<?php

declare(strict_types=1);

namespace Tests\ChiTeck\Stopwatch\Fixture;

use ChiTeck\Stopwatch\Data\Context;
use ChiTeck\Stopwatch\Data\Report;
use ChiTeck\Stopwatch\Data\Tick;

/**
 * {@selfdoc}
 */
enum ReportSet
{
    case ALPHA;
    case BETA;
    case GAMMA;
    case DELTA;

    /**
     * {@selfdoc}
     */
    public function build(): Report
    {
        $location = [
            'file' => 'example.php',
            'line' => 10,
            'function' => 'example',
            'class' => __CLASS__,
            'type' => '->',
        ];
        return match ($this) {
            self::ALPHA => new Report(
                new Context('101', 'Alpha', new \DateTimeImmutable('2024-04-12 01:00')),
                [new Tick('Tick #1', 12_345, 123, $location, [])],
            ),
            self::BETA => new Report(
                new Context('102', 'Beta', new \DateTimeImmutable('2024-04-12 02:00')),
                [
                    new Tick('Tick #1', 10_000, 1_000, $location, ['abc']),
                    new Tick('Tick #2', 20_000, 2_000, $location, []),
                    new Tick('Tick #3', 30_000, 3_000, $location, ['def']),
                ],
            ),
            self::GAMMA => new Report(
                new Context('103', 'Gamma', new \DateTimeImmutable('2024-04-12 03:00')),
                [new Tick('Tick #1', 12_345, 123, $location, ['Кириллица'])],
            ),
            self::DELTA => new Report(
                new Context('104', 'Delta', new \DateTimeImmutable('2024-04-12 04:00')),
                [],
            ),
        };
    }

    /**
     * {@selfdoc}
     */
    public function hash(): string
    {
        return match ($this) {
            self::ALPHA => 'b18b0e98ff0fa9a06ca91cc2c82e419d',
            self::BETA => '1af6809ef47844c7ead44f8f65edf0ff',
            self::GAMMA => 'fe13f014b4871c474e74322e5ecc0dbd',
            self::DELTA => 'fe13f014b4871c474e74322e5ecc0dbd',
        };
    }
}
