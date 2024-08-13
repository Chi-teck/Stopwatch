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
        public float|int $timestamp,
        public int $memory,
        /**
         * @var array{
         *     function: string,
         *     line?: int,
         *     file?: string,
         *     class?: class-string,
         *     type?: '->'|'::'
         * } $location
         */
        public array $location,
        public mixed $data,
    ) {}
}
