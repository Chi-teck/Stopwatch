<?php

declare(strict_types=1);

namespace ChiTeck\Stopwatch\Formatter;

use ChiTeck\Stopwatch\Data\Report;

/**
 * Formats stopwatch as plain text.
 */
final readonly class Text extends AbstractFormatter
{
    /**
     * {@selfdoc}
     */
    public function format(Report $report): string
    {
        $ticks = $report->ticks;

        if (\count($ticks) === 0) {
            return '';
        }

        $headers = ['Tick', 'Timestamp, ms', 'Increment, ms', 'Memory, MB', 'Location'];
        $rows = [$headers, ...parent::formatTicks($report->ticks)];

        $column_widths = \array_map(
            static fn (int $index): int => \max(\array_map('mb_strlen', \array_column($rows, $index))),
            \range(0, 4),
        );

        $hr = static function (string $prefix, string $line, string $suffix) use ($column_widths): string {
            return $prefix . \str_repeat('─', \array_sum($column_widths) + 14) . $suffix . \PHP_EOL;
        };

        $format_row = static function (array $row, int $pad_type) use ($column_widths): string {
            $stub = [
                '',
                \str_pad($row[0], $column_widths[0], ' '),
                \str_pad($row[1], $column_widths[1], ' ', $pad_type),
                \str_pad($row[2], $column_widths[2], ' ', $pad_type),
                \str_pad($row[3], $column_widths[3], ' ', $pad_type),
                \str_pad($row[4], $column_widths[4], ' '),
                '',
            ];
            return \trim(\implode(' │ ', $stub));
        };

        $output = 'ID:    ' . $report->id . \PHP_EOL;
        $output .= 'Label: ' . $report->label . \PHP_EOL;
        $output .= 'Date:  ' . $report->createdAt->format(\DateTimeInterface::ATOM) . \PHP_EOL;

        $output .= $hr('┌', '─', '┐');
        foreach ($rows as $delta => $row) {
            if ($delta === 1) {
                $output .= $hr('├', '─', '┤');
            }
            $pad_type = $delta === 0 ? \STR_PAD_BOTH : \STR_PAD_LEFT;
            $output .= $format_row($row, $pad_type) . \PHP_EOL;
        }
        $output .= $hr('└', '─', '┘');

        return $output;
    }
}
