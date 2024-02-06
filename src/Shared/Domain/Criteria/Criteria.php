<?php

declare(strict_types=1);

namespace App\Shared\Domain\Criteria;

final readonly class Criteria
{
    private function __construct(
        private Filters $filters,
        private Order $order,
    ) {
    }

    public static function create(
        Filters $filters,
        Order $order,
    ): self {
        return new self($filters, $order);
    }

    public static function fromPrimitives(
        array $filters,
        ?string $orderBy,
        ?string $orderType
    ): self {
        return new self(
            Filters::fromPrimitives($filters),
            Order::fromPrimitives($orderBy ?? null, $orderType ?? null),
        );
    }

    public function getFilters(): Filters
    {
        return $this->filters;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function hasOrder(): bool
    {
        return !$this->getOrder()->isNone();
    }

    public function hasFilters(): bool
    {
        return $this->getFilters()->count() > 0;
    }
}
