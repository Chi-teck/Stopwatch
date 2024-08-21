<?php

declare(strict_types=1);

namespace ChiTeck\Stopwatch\Dumper;

use ChiTeck\Stopwatch\Contract\DumperInterface;
use ChiTeck\Stopwatch\Data\Report;

/**
 * Dumps a report using multiple dumpers.
 */
final readonly class Chained implements DumperInterface
{
    /**
     * @var \ChiTeck\Stopwatch\Contract\DumperInterface[]
     */
    private array $dumpers;

    /**
     * {@selfdoc}
     */
    public function __construct(DumperInterface ...$dumpers)
    {
        $this->dumpers = $dumpers;
    }

    /**
     * {@inheritdoc}
     */
    public function dump(Report $report): void
    {
        foreach ($this->dumpers as $dumper) {
            $dumper->dump($report);
        }
    }
}
