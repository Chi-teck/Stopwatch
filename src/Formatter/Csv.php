<?php

declare(strict_types=1);

namespace ChiTeck\Stopwatch\Formatter;

use ChiTeck\Stopwatch\Contract\FormatterInterface;
use ChiTeck\Stopwatch\Data\Report;

/**
 * Formats Stopwatch report as CSV.
 */
final readonly class Csv implements FormatterInterface
{
    /**
     * {@selfdoc}
     */
    public function format(Report $report): string
    {
        $fp = \fopen('php://temp', 'r+');
        \assert(\is_resource($fp));
        $origin = $report->ticks[0]->timestamp;
        foreach ($report->ticks as $delta =>  $tick) {
            $lap = $delta > 0 ? ($tick->timestamp - $report->ticks[$delta - 1]->timestamp) : 0;
            $row = [
                \mb_substr($tick->name, 0, 64),
                \number_format($tick->timestamp - $origin, 3, thousands_separator: ''),
                \number_format($lap, 3, thousands_separator: ''),
                \number_format($tick->memory / 1_000_000, 3, thousands_separator: ''),
            ];
            \fputcsv($fp, $row);
        }
        \rewind($fp);
        // @phpstan-ignore-next-line
        return \stream_get_contents($fp);
    }

}
