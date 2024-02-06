<?php

namespace App\Tests\Unit\Shared\Infrastruture\Converters;

use App\Shared\Domain\Criteria\Filters;
use App\Shared\Infrastructure\Converters\SqlCriteriaConverter;
use App\Tests\Unit\Shared\Domain\Criteria\CriteriaMother;
use App\Tests\Unit\Shared\Domain\Criteria\FiltersMother;
use App\Tests\Unit\Shared\Domain\Criteria\OrderMother;
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

    /** @test */
    public function itShouldConvertToSqlWithOneFilter(): void
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

    /** @test */
    public function itShouldConvertToSqlWithFilters(): void
    {
        // GIVEN

        $criteria = CriteriaMother::create(
            Filters::fromValues(
                [
                    [
                        'field'    => 'name',
                        'operator' => '=',
                        'value'    => 'value',
                    ],
                    [
                        'field'    => 'surname',
                        'operator' => '=',
                        'value'    => 'value',
                    ],
                ]
            )
        );

        // WHEN

        $query = $this->sqlConverter->convert(['name', 'surname'], 'table', $criteria);

        // THEN

        self::assertEquals('SELECT name, surname FROM table WHERE name = value AND surname = value', $query);
    }

    /** @test */
    public function itShouldConvertToSqlSorted(): void
    {
        // GIVEN

        $criteria = CriteriaMother::create(
            FiltersMother::empty(),
            OrderMother::withOneSorted(
                'name',
                'ASC'
            )
        );

        // WHEN

        $query = $this->sqlConverter->convert(['name', 'surname'], 'table', $criteria);

        // THEN

        self::assertEquals('SELECT name, surname FROM table ORDER BY name ASC', $query);
    }

    /** @test */
    public function itShouldConvertToSqlSortedAndFilters(): void
    {
        // GIVEN

        $criteria = CriteriaMother::create(
            Filters::fromValues(
                [
                    [
                        'field'    => 'name',
                        'operator' => '=',
                        'value'    => 'value',
                    ],
                    [
                        'field'    => 'surname',
                        'operator' => '=',
                        'value'    => 'value',
                    ],
                ]
            ),
            OrderMother::withOneSorted(
                'name',
                'ASC'
            )
        );

        // WHEN

        $query = $this->sqlConverter->convert(['name', 'surname'], 'table', $criteria);

        // THEN

        self::assertEquals('SELECT name, surname FROM table WHERE name = value AND surname = value ORDER BY name ASC', $query);
    }

    /** @test */
    public function itShouldConvertToSqlSortedAndFiltersAndFilterContain(): void
    {
        // GIVEN

        $criteria = CriteriaMother::create(
            Filters::fromValues(
                [
                    [
                        'field'    => 'name',
                        'operator' => '=',
                        'value'    => 'value',
                    ],
                    [
                        'field'    => 'surname',
                        'operator' => 'CONTAINS',
                        'value'    => 'value',
                    ],
                ]
            ),
            OrderMother::withOneSorted(
                'name',
                'ASC'
            )
        );

        // WHEN

        $query = $this->sqlConverter->convert(['name', 'surname'], 'table', $criteria);

        // THEN

        self::assertEquals('SELECT name, surname FROM table WHERE name = value AND surname LIKE "%value%" ORDER BY name ASC', $query);
    }
}
