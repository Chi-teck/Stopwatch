<?php

declare(strict_types=1);

namespace ChiTeck\Stopwatch\Dumper;

use ChiTeck\Stopwatch\Contract\DumperInterface;
use ChiTeck\Stopwatch\Contract\FormatterInterface;
use ChiTeck\Stopwatch\Data\Report;

/**
 * Dumps report to a local buffer.
 */
final class Buffered implements DumperInterface
{
    private string $buffer = '';

    /**
     * {@selfdoc}
     */
    public function __construct(
        private readonly FormatterInterface $formatter,
    ) {}

    /**
     * {@inheritdoc}
     */
    public function dump(Report $report): void
    {
        $this->buffer .= $this->formatter->format($report);
    }

    /**
     * Empties buffer and returns its content.
     */
    public function fetch(): string
    {
        $content = $this->buffer;
        $this->buffer = '';
        return $content;
    }
}
