<?php

declare(strict_types=1);

namespace ChiTeck\Stopwatch\Dumper;

use ChiTeck\Stopwatch\Contract\DumperInterface;
use ChiTeck\Stopwatch\Contract\FormatterInterface;
use ChiTeck\Stopwatch\Data\Report;

/**
 * Dumps report to any stream resource
 *
 * Can be used to store data into local files, IO streams like (php://stdout), etc.
 */
final readonly class File implements DumperInterface
{
    /**
     * {@selfdoc}
     */
    public function __construct(
        private FormatterInterface $formatter,
        private string $filename,
    ) {}

    /**
     * {@inheritdoc}
     */
    public function dump(Report $report): void
    {
        $output = $this->formatter->format($report);
        $result = @\file_put_contents($this->filename, $output);
        if ($result === false) {
            throw new \RuntimeException(\sprintf('Could not write to %s file', $this->filename));
        }
    }
}
