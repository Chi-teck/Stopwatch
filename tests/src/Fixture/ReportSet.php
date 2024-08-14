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
                [new Tick('Tick #1', 12345, 123, $location, [])],
            ),
            self::BETA => new Report(
                new Context('102', 'Beta', new \DateTimeImmutable('2024-04-12 02:00')),
                [new Tick('Tick #1', 12345, 123, $location, ['abc'])],
            ),
            self::GAMMA => new Report(
                new Context('103', 'Gamma', new \DateTimeImmutable('2024-04-12 03:00')),
                [new Tick('Tick #1', 12345, 123, $location, ['Кириллица'])],
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
            self::BETA => '9dac51dbc472a9019ceabbebb85b2988',
            self::GAMMA => 'fe13f014b4871c474e74322e5ecc0dbd',
        };
    }
}
