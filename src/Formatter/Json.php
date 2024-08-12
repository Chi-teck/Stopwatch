<?php

declare(strict_types=1);

namespace ChiTeck\Stopwatch\Formatter;

use ChiTeck\Stopwatch\Contract\FormatterInterface;
use ChiTeck\Stopwatch\Data\Report;

/**
 * Formats Stopwatch report as encoded JSON.
 */
final readonly class Json implements FormatterInterface
{
    /**
     * {@selfdoc}
     */
    public function format(Report $report): string
    {
        return \json_encode($report, \JSON_PRETTY_PRINT | \JSON_UNESCAPED_UNICODE);
    }

}
