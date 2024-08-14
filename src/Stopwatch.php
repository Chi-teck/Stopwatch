<?php

declare(strict_types=1);

namespace ChiTeck\Stopwatch;

use ChiTeck\Stopwatch\Contract\DumperInterface;
use ChiTeck\Stopwatch\Data\Context;
use ChiTeck\Stopwatch\Data\Report;
use ChiTeck\Stopwatch\Data\Tick;

/**
 * A helper to profile PHP code.
 */
final class Stopwatch
{
    /**
     * {@selfdoc}
     */
    private static self $instance;

    /**
     * @var \ChiTeck\Stopwatch\Data\Tick[]
     */
    private array $ticks = [];

    /**
     * {@selfdoc}
     */
    public function __construct(
        private readonly DumperInterface $dumper,
    ) {}

    /**
     * Registers a new tick.
     */
    public function tick(string $name = '', mixed $data = null): void
    {
        $backtrace = \debug_backtrace(\DEBUG_BACKTRACE_IGNORE_ARGS);
        $index = \count($backtrace) > 1 ? 1 : 0;
        $this->ticks[] = new Tick(
            name: $name,
            timestamp: \hrtime(true) / 1_000_000,
            memory: \memory_get_usage(),
            location: $backtrace[$index],
            data: $data,
        );
    }

    /**
     * {@selfdoc}
     */
    public function getReport(): Report
    {
        $label = \PHP_SAPI === 'cli' ?
          \implode(' ', [\PHP_BINARY, $_SERVER['PHP_SELF'], ...$_SERVER['argv']]) :
          $_SERVER['REQUEST_METHOD'] . ' ' . $_SERVER['REQUEST_URI'];
        $context = new Context(
            id: \uniqid(),
            label: $label,
            createdAt: new \DateTimeImmutable(),
        );
        return new Report($context, $this->ticks);
    }

    /**
     * {@selfdoc}
     */
    public function dump(): void
    {
        $this->dumper->dump($this->getReport());
    }

    /**
     * Creates a stopwatch instance with default configuration.
     */
    public static function create(): self
    {
        $formatter = \PHP_SAPI === 'cli' ? new Formatter\Text() : new Formatter\Html();
        return new self(
            new Dumper\File($formatter, 'php://output'),
        );
    }

    /**
     * {@selfdoc}
     */
    public static function set(self $stopwatch): self
    {
        return self::$instance = $stopwatch;
    }

    /**
     * {@selfdoc}
     */
    public static function get(): self
    {
        return self::$instance ?? throw new \LogicException('The stopwatch is not configured yet.');
    }
}
