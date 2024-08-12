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
     * Formats backtrace element location.
     *
     * @see \debug_backtrace()
     */
    final protected static function formatLocation(array $location): string
    {
        return \sprintf(
            '%s[%d]:%s%s%s()',
            \substr($location['file'], strlen($_SERVER['DOCUMENT_ROOT'])),
            $location['line'],
            $location['class'] ?? '',
            $location['type'] ?? '',
            $location['function'],
        );
    }

}
