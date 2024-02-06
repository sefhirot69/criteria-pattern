<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Converters;

use App\Shared\Domain\Criteria\Criteria;
use App\Shared\Domain\Criteria\Filter;

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
                $query .= $filter->field().' '.$filter->operator()->value.' '.$filter->value();
            }
        }

        return $query;
    }
}
