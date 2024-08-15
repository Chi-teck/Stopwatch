<?php

declare(strict_types=1);

namespace Tests\ChiTeck\Stopwatch\Fixture;

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
    public function get(): Report
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
                id: '101',
                label: 'Alpha',
                createdAt: new \DateTimeImmutable('2024-04-12 01:00'),
                ticks: [new Tick('Tick #1', 12_345, 123, $location, [])],
            ),
            self::BETA => new Report(
                id: '102',
                label: 'Beta',
                createdAt: new \DateTimeImmutable('2024-04-12 02:00'),
                ticks: [
                    new Tick('Tick #1', 10_000, 1_000, $location, ['abc']),
                    new Tick('Tick #2', 20_000, 2_000, $location, []),
                    new Tick('Tick #3', 30_000, 3_000, $location, ['def']),
                ],
            ),
            self::GAMMA => new Report(
                id: '103',
                label: 'Gamma',
                createdAt: new \DateTimeImmutable('2024-04-12 03:00'),
                ticks: [new Tick('Tick #1', 12_345, 123, $location, ['Кириллица'])],
            ),
            self::DELTA => new Report(
                id: '104',
                label: 'Delta',
                createdAt: new \DateTimeImmutable('2024-04-12 04:00'),
                ticks: [],
            ),
        };
    }
}
