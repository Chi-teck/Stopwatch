<?php

declare(strict_types=1);

namespace ChiTeck\Stopwatch\Data;

/**
 * A data structure to represent profile results.
 */
final readonly class Report
{
    /**
     * {@selfdoc}
     */
    public function __construct(
        public Context $context,
        /* @var \ChiTeck\Stopwatch\Data\Tick [] */
        public array $ticks = [],
    ) {
    }

}
