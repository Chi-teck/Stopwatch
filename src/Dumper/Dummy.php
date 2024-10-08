<?php

declare(strict_types=1);

namespace ChiTeck\Stopwatch\Dumper;

use ChiTeck\Stopwatch\Contract\DumperInterface;
use ChiTeck\Stopwatch\Data\Report;

/**
 * Provides a null implementation for the report dumper.
 */
final readonly class Dummy implements DumperInterface
{
    /**
     * {@inheritdoc}
     */
    public function dump(Report $report): void
    {
        // Intentionally empty.
    }
}
