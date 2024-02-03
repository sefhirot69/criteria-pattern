<?php

declare(strict_types=1);

namespace App\Shared\Domain\Criteria;

final class Order
{
    private function __construct(
        private readonly OrderBy $orderBy,
        private readonly OrderType $orderType
    ) {
    }

    public static function create(OrderBy $orderBy, OrderType $orderType): self
    {
        return new self($orderBy, $orderType);
    }

    public function getOrderBy(): OrderBy
    {
        return $this->orderBy;
    }

    public function getOrderType(): OrderType
    {
        return $this->orderType;
    }
}
