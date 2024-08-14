<?php

declare(strict_types=1);

namespace ChiTeck\Stopwatch\Formatter;

use ChiTeck\Stopwatch\Contract\FormatterInterface;

/**
 * Base class for report formatters.
 */
abstract readonly class AbstractFormatter implements FormatterInterface
{
    /**
     * @param \ChiTeck\Stopwatch\Data\Tick[] $ticks
     *
     * @return list<array{string, non-empty-string, non-empty-string,non-empty-string}>
     */
    final protected static function formatTicks(array $ticks): array
    {
        if (\count($ticks) === 0) {
            return [];
        }
        $rows = [];
        $origin = $ticks[0]->timestamp;
        foreach ($ticks as $delta => $tick) {
            $lap = $delta > 0 ? ($tick->timestamp - $ticks[$delta - 1]->timestamp) : 0;
            $rows[] = [
                \mb_substr($tick->name, 0, 64),
                \number_format($tick->timestamp - $origin, 3, thousands_separator: ''),
                \number_format($lap, 3, thousands_separator: ''),
                \number_format($tick->memory / 1_000_000, 3, thousands_separator: ''),
            ];
        }
        return $rows;
    }

    /**
     * Formats backtrace element location.
     *
     * @phpstan-param array{
     *   function?: string,
     *   line?: int,
     *   file?: string,
     *   class?: class-string,
     *   type?: '->'|'::',
     * } $location
     *
     * @see \debug_backtrace()
     */
    final protected static function formatLocation(array $location): string
    {
        return \sprintf(
            '%s:%d %s%s%s()',
            \substr($location['file'] ?? '', \strlen($_SERVER['DOCUMENT_ROOT'])),
            $location['line'] ?? '',
            $location['class'] ?? '',
            $location['type'] ?? '',
            $location['function'] ?? '',
        );
    }
}
