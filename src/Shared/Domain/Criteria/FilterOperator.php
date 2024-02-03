<?php

declare(strict_types=1);

namespace App\Shared\Domain\Criteria;

final class FilterOperator
{
    private function __construct(private readonly Operator $operator)
    {
    }

    public function value(): string
    {
        return $this->operator->value;
    }
}
