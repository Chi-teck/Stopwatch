<?php

declare(strict_types=1);

namespace ChiTeck\Stopwatch\Dumper;

use ChiTeck\Stopwatch\Contract\DumperInterface;
use ChiTeck\Stopwatch\Data\Report;

/**
 * Provides a null implementation for report dumper.
 */
final class Dummy implements DumperInterface
{
    /**
     * {@inheritdoc}
     */
    public function dump(Report $report): void
    {
        // Intentionally empty.
    }
}
