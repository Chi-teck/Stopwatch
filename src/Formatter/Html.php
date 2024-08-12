<?php

declare(strict_types=1);

namespace ChiTeck\Stopwatch\Formatter;

use ChiTeck\Stopwatch\Data\Report;
use ChiTeck\Stopwatch\Data\Tick;

/**
 * Formats stopwatch as plain text.
 */
final readonly class Html extends AbstractFormatter
{
    /**
     * {@selfdoc}
     */
    public function format(Report $report): string
    {
        $ticks = $report->ticks;

        $origin = $ticks[0]->timestamp;
        $rows = [];
        foreach ($report->ticks as $delta => $tick) {
            \assert($tick instanceof Tick);
            $lap = $delta > 0 ? ($tick->timestamp - $ticks[$delta - 1]->timestamp) : 0;
            $name = \mb_substr($tick->name, 0, 64);
            $timestamp = \number_format($tick->timestamp - $origin, 3, thousands_separator: '');
            $increment = \number_format($lap, 3, thousands_separator: '');
            $memory = \number_format($tick->memory / 1_000_000, 3, thousands_separator: '');
            $location = self::formatLocation($tick->location);

            $rows[] = <<< HTML
        <tr>
          <td>$name</td>
          <td>$timestamp</td>
          <td>$increment</td>
          <td>$memory</td>
          <td>$location</td>
        </tr>
        HTML;
        }
        $tbody = \implode("\n", $rows);

        $id = $report->context->id;
        $title = $report->context->label;
        $date = $report->context->createdAt->format(\DateTimeInterface::ATOM);

        return <<< HTML
      <style>
        .sw-report__summary {
          font-size: 0.85em;
          margin-bottom: 0.5em;;
        }
        .sw-report table {
          border-collapse: collapse;
        }
        .sw-report th {
          text-align: center;
        }
        .sw-report__label {
          font-weight: bold;
        }
        .sw-report__label:after {
          content: ':';
        }
        .sw-report td:not(:first-child):not(:last-child) {
          text-align: right;
        }
        .sw-report :where(th, td) {
          border: solid 1px;
          padding: 0.5em;
        }
      </style>
      <div class="sw-report">
        <div class="sw-report__summary">
          <div class="sw-report__item">
            <span class="sw-report__label">ID</span>
            <span class="sw-report__value">$id</span>
          </div>
          <div class="sw-report__item">
            <span class="sw-report__label">Title</span>
            <span class="sw-report__value">$title</span>
          </div>
          <div class="sw-report__item">
            <span class="sw-report__label">Date</span>
            <span class="sw-report__value">$date</span>
          </div>
        </div>
        <table class="sw-report__ticks">
          <thead>
            <tr>
            <th>Tick</th>
            <th>Timestamp, ms</th>
            <th>Increment, ms</th>
            <th>Memory, MB</th>
            <th>Location</th>
          </tr>
          </thead>
            <tbody>$tbody</tbody>
        </table>
      </div>
      HTML;
    }

}
