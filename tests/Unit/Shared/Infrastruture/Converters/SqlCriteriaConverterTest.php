<?php

namespace App\Tests\Unit\Shared\Infrastruture\Converters;

use App\Shared\Domain\Criteria\Filters;
use App\Shared\Infrastructure\Converters\SqlCriteriaConverter;
use App\Tests\Unit\Shared\Domain\Criteria\CriteriaMother;
use PHPUnit\Framework\TestCase;

class SqlCriteriaConverterTest extends TestCase
{
    private SqlCriteriaConverter $sqlConverter;

    protected function setUp(): void
    {
        $this->sqlConverter = new SqlCriteriaConverter();
    }

    /** @test */
    public function itShouldConvertToSqlWithoutFilters(): void
    {
        // GIVEN

        $criteria = CriteriaMother::create(
            Filters::fromValues([]),
        );

        // WHEN

        $query = $this->sqlConverter->convert(['name', 'surname'], 'table', $criteria);

        // THEN

        self::assertEquals('SELECT name, surname FROM table', $query);
    }

    /** @test  */
    public function itShouldConvertToSqlWithFilters(): void
    {
        // GIVEN

        $criteria = CriteriaMother::withOneFilter(
            'name',
            '=',
            'value'
        );

        // WHEN

        $query = $this->sqlConverter->convert(['name', 'surname'], 'table', $criteria);

        // THEN

        self::assertEquals('SELECT name, surname FROM table WHERE name = value', $query);
    }
}
