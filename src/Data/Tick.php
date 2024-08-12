<?php

declare(strict_types=1);

namespace ChiTeck\Stopwatch\Data;

/**
 * {@selfdoc}
 */
final readonly class Tick
{
    public function __construct(
        public string $name,
        public int|float $timestamp,
        public int $memory,
        public array $location,
        public mixed $data,
    ) {
    }

}
