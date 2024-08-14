<?php

declare(strict_types=1);

namespace ChiTeck\Stopwatch\Formatter;

use ChiTeck\Stopwatch\Data\Report;

/**
 * Formats Stopwatch report as CSV document.
 */
final readonly class Csv extends AbstractFormatter
{
    /**
     * {@selfdoc}
     */
    public function format(Report $report): string
    {
        $fp = \fopen('php://temp', 'r+');
        \assert(\is_resource($fp));
        foreach (parent::formatTicks($report->ticks) as $formatted_tick) {
            \fputcsv($fp, $formatted_tick);
        }
        \rewind($fp);
        // @phpstan-ignore-next-line
        return \stream_get_contents($fp);
    }
}
