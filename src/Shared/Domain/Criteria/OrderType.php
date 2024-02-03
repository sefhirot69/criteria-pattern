<?php

declare(strict_types=1);

namespace App\Shared\Domain\Criteria;

final class OrderType
{
    private function __construct(private readonly OrderTypes $orderTypes)
    {
    }

    public static function create(
        OrderTypes $orderTypes
    ): self {
        return new self($orderTypes);
    }

    public function value(): string
    {
        return $this->orderTypes->value;
    }
}
