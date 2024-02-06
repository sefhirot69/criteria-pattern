<?php

declare(strict_types=1);

namespace App\Shared\Domain;

abstract readonly class Collection implements \Countable, \IteratorAggregate
{
    public function __construct(private array $items)
    {
        $this->assertArrayOf($this->type(), $items);
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->items());
    }

    public function count(): int
    {
        return count($this->items());
    }

    abstract protected function type(): string;

    protected function items(): array
    {
        return $this->items;
    }

    private function assertArrayOf(string $class, array $items): void
    {
        foreach ($items as $item) {
            if (!$item instanceof $class) {
                throw new \InvalidArgumentException(sprintf('The object <%s> is not an instance of <%s>', $class, $item::class));
            }
        }
    }
}
