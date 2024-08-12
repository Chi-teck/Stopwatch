<?php

declare(strict_types=1);

namespace ChiTeck\Stopwatch\Dumper;

use ChiTeck\Stopwatch\Contract\DumperInterface;
use ChiTeck\Stopwatch\Contract\FormatterInterface;
use ChiTeck\Stopwatch\Data\Report;

/**
 * Dumps report to any stream resource
 *
 * Can be used to store into php://stdout, remote and local files, etc.
 */
final readonly class Stream implements DumperInterface
{

    public function __construct(
        private FormatterInterface $formatter,
        private string $stream,
    ) {}

    /**
     * {@inheritdoc}
     */
    public function dump(Report $report): void
    {
        $output = $this->formatter->format($report);
        \file_put_contents($this->stream, $output);
    }

}
