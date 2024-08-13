<?php

declare(strict_types=1);

namespace ChiTeck\Stopwatch\Dumper;

use ChiTeck\Stopwatch\Contract\DumperInterface;
use ChiTeck\Stopwatch\Data\Report;

/**
 * A dumper that dumps report on shutdown.
 */
final readonly class Shutdown implements DumperInterface
{
    /**
     * {@selfdoc}
     */
    public function __construct(private DumperInterface $dumper) {}

    /**
     * {@inheritdoc}
     */
    public function dump(Report $report): void
    {
        \register_shutdown_function($this->doDump(...), $report);
    }

    /**
     * {@selfdoc}
     */
    public function doDump(Report $report): void
    {
        $this->dumper->dump($report);
    }
}
