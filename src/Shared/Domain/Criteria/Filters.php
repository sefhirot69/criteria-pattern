<?php

declare(strict_types=1);

namespace App\Shared\Domain\Criteria;

final class Filters
{
    private function __construct(
        /** @var array<int, Filter> $filters */
        private readonly array $filters
    ) {
    }

    /**
     * @param array<int, Filter> $filters
     *
     * @return self
     */
    public static function create(array $filters): self
    {
        return new self($filters);
    }

    /** @return array<int, Filter> */
    public function filters(): array
    {
        return $this->filters;
    }
}
