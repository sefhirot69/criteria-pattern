<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Converters;

use App\Shared\Domain\Criteria\Criteria;
use App\Shared\Domain\Criteria\Filter;
use App\Shared\Domain\Criteria\FilterOperator;

final class SqlCriteriaConverter
{
    public function convert(
        array $fieldToSelect,
        string $tableName,
        Criteria $criteria
    ): string {
        $query = 'SELECT '.implode(', ', $fieldToSelect).' FROM '.$tableName;

        if ($criteria->hasFilters()) {
            $query .= ' WHERE ';

            /** @var Filter $filter */
            foreach ($criteria->getFilters() as $key => $filter) {
                if ($key > 0) {
                    $query .= ' AND ';
                }

                if ($filter->operator()->equalsTo(FilterOperator::CONTAINS)) {
                    $query .= $filter->field().' LIKE "%'.$filter->value().'%"';
                } else {
                    $query .= $filter->field().' '.$filter->operator()->value.' '.$filter->value();
                }
            }
        }

        if ($criteria->hasOrder()) {
            $order = $criteria->getOrder();
            $query .= ' ORDER BY '.$order->getOrderBy()->value().' '.$order->getOrderType()->value();
        }

        return $query;
    }
}
