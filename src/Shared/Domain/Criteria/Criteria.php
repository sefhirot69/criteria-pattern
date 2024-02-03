<?php

declare(strict_types=1);

namespace App\Shared\Domain\Criteria;

final class Criteria
{
    private function __construct(
        private readonly Filters $filters,
        private readonly Order $order,
        private ?int $offset,
        private ?int $limit
    ) {
    }

    public static function create(
        Filters $filters,
        Order $order,
        ?int $offset,
        ?int $limit
    ): self {
        return new self($filters, $order, $offset, $limit);
    }

    public function getFilters(): Filters
    {
        return $this->filters;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function getOffset(): ?int
    {
        return $this->offset;
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }
}
