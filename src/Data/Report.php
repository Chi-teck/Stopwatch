<?php

declare(strict_types=1);

namespace ChiTeck\Stopwatch\Data;

/**
 * A context structure to represent profile results.
 */
final readonly class Report implements \JsonSerializable
{
    /**
     * {@selfdoc}
     */
    public function __construct(
        public string $id,
        public string $label,
        public \DateTimeImmutable $createdAt,
        /** @var \ChiTeck\Stopwatch\Data\Tick[] $ticks */
        public array $ticks,
    ) {}

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): \stdClass
    {
        return (object) [
            'id' => $this->id,
            'label' => $this->label,
            'createdAt' => $this->createdAt->format(\DateTimeInterface::ATOM),
            'ticks' => $this->ticks,
        ];
    }
}
