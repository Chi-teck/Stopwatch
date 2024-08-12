<?php

declare(strict_types=1);

namespace ChiTeck\Stopwatch\Contract;

use ChiTeck\Stopwatch\Data\Report;

/**
 * Formats a report as string.
 */
interface FormatterInterface
{
    /**
     * {@selfdoc}
     */
    public function format(Report $report): string;


}
