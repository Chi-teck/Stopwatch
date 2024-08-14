<?php

declare(strict_types=1);

namespace ChiTeck\Stopwatch\Dumper;

use ChiTeck\Stopwatch\Contract\DumperInterface;
use ChiTeck\Stopwatch\Contract\FormatterInterface;
use ChiTeck\Stopwatch\Data\Report;

/**
 * Dumps report to a file.
 *
 * Can be used to store data into local files, streams like (php://stdout), etc.
 */
final readonly class File implements DumperInterface
{
    /**
     * {@selfdoc}
     */
    public function __construct(
        private FormatterInterface $formatter,
        private string $filename,
        private bool $append = true
    ) {}

    /**
     * {@inheritdoc}
     */
    public function dump(Report $report): void
    {
        $output = $this->formatter->format($report) . \PHP_EOL;
        $result = @\file_put_contents($this->filename, $output, $this->append ? \FILE_APPEND : 0);
        if ($result === false) {
            throw new \RuntimeException(\sprintf('Could not write to %s file', $this->filename));
        }
    }
}
