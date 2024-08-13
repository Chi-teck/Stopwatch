<?php

declare(strict_types=1);

namespace ChiTeck\Stopwatch\Contract;

use ChiTeck\Stopwatch\Data\Report;

/**
 * Dumps stopwatch report to a storage.
 */
interface DumperInterface
{
    /**
     * {@selfdoc}
     */
    public function dump(Report $report): void;
}
