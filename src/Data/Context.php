<?php

declare(strict_types=1);

namespace ChiTeck\Stopwatch\Data;

/**
 * Defines profiling context.
 */
final readonly class Context implements \JsonSerializable
{
    /**
     * {@selfdoc}
     */
    public function __construct(
        public string $id,
        public string $label,
        public \DateTimeImmutable $createdAt,
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
        ];
    }

}
