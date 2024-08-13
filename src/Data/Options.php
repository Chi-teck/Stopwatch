<?php

declare(strict_types=1);

namespace ChiTeck\Stopwatch\Data;

/**
 * Defines options for the stopwatch.
 */
final readonly class Options
{
    /**
     * {@selfdoc}
     */
    public function __construct(
        public bool $autoDump = false,
        public bool $verbose = true,
    ) {}
}
