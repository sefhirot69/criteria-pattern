<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Domain\Criteria;

use App\Shared\Domain\Criteria\Criteria;
use App\Shared\Domain\Criteria\Filters;
use App\Shared\Domain\Criteria\Order;

final class CriteriaMother
{
    public static function create(
        Filters $filters,
        Order $order = null,
    ): Criteria {
        return Criteria::create(
            $filters,
            $order ?: OrderMother::none()
        );
    }

    public static function random(): Criteria
    {
        return self::create(
            FiltersMother::create([]),
            OrderMother::random()
        );
    }

    public static function withOneFilter(
        string $field,
        string $operator,
        string $value
    ): Criteria {
        return Criteria::fromPrimitives(
            [
                [
                    'field'    => $field,
                    'operator' => $operator,
                    'value'    => $value,
                ],
            ],
            null,
            null
        );
    }
}
