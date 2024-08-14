<?php

declare(strict_types=1);

namespace ChiTeck\Stopwatch\Formatter;

use ChiTeck\Stopwatch\Contract\FormatterInterface;
use ChiTeck\Stopwatch\Data\Report;

/**
 * Formats Stopwatch report as JSON document.
 */
final readonly class Json implements FormatterInterface
{
    /**
     * {@selfdoc}
     */
    public function __construct(
        private int $options = \JSON_PRETTY_PRINT | \JSON_UNESCAPED_UNICODE | \JSON_UNESCAPED_SLASHES,
    ) {}

    /**
     * {@selfdoc}
     */
    public function format(Report $report): string
    {
        return \json_encode($report, $this->options | \JSON_THROW_ON_ERROR);
    }
}
