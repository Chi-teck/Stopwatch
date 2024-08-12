<?php

declare(strict_types=1);

namespace ChiTeck\Stopwatch\Dumper;

use ChiTeck\Stopwatch\Contract\DumperInterface;
use ChiTeck\Stopwatch\Data\Report;

/**
 * Provides a Server-Dumping implementation for report dumper.
 */
final class ServerTiming implements DumperInterface
{
    /**
     * {@inheritdoc}
     */
    public function dump(Report $report): void
    {
        $template = 'Server-Timing: %s;dur=%f memory;dur=%f';
        $origin = $report->ticks[0]->timestamp;
        foreach ($report->ticks as $tick) {
            \header(\sprintf($template, $tick->name, $tick->timestamp - $origin, $tick->memory), false);
        }
    }

}
