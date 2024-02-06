<?php

declare(strict_types=1);

namespace App\Shared\Domain\Criteria;

enum OrderTypes: string
{
    case ASC  = 'asc';
    case DESC = 'desc';
    case NONE = 'none';

    public function equalsTo(self $types): bool
    {
        return $this->value === $types->value;
    }

    public function isNone(): bool
    {
        return $this->equalsTo(self::NONE);
    }
}
