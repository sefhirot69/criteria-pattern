<?php

declare(strict_types=1);

namespace App\Shared\Domain\Criteria;

enum FilterOperator: string
{
    case EQUAL        = '=';
    case NOT_EQUAL    = '!=';
    case GT           = '>';
    case GTE          = '>=';
    case LT           = '<';
    case LTE          = '<=';
    case CONTAINS     = 'CONTAINS';
    case NOT_CONTAINS = 'NOT_CONTAINS';
}
