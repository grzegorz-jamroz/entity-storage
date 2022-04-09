<?php

declare(strict_types=1);

namespace Tests\Unit\Storage\JsonStorageAction;

use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;
use PHPUnit\Framework\TestCase;
use Tests\Traits\JsonStorageAction\SetUp;

class FindByTest extends TestCase
{
    use SetUp;

    public function testShouldReturnEmptyArrayCollectionWhenNoResultMatches()
    {
        // Given
        $criteria = new Criteria();
        $expr = new Comparison('email', Comparison::EQ, 'superuser@email.com');
        $criteria->where($expr);

        // When
        $results = $this->testStorage->findBy($criteria);

        // Then
        $this->assertCount(0, $results);
    }

    public function testShouldReturnOneEntityWhenOnlyOneResultMatches()
    {
        // Given
        $criteria = new Criteria();
        $expr = new Comparison('email', Comparison::EQ, 'tom@email.com');
        $criteria->where($expr);

        // When
        $results = $this->testStorage->findBy($criteria);

        // Then
        $this->assertCount(1, $results);
        $this->assertEquals(
            $this->users->get('f3e56592-0bfd-4669-be39-6ac8ab5ac55f')->jsonSerialize(),
            $results->first()->jsonSerialize()
        );
    }

    public function testShouldReturnTwoEntitiesWhenOnlyTwoResultsMatches()
    {
        // Given
        $criteria = new Criteria();
        $expr = new Comparison('countryLowerCase', Comparison::CONTAINS, 'kingdom');
        $criteria->where($expr);

        // When
        $results = $this->testStorage->findBy($criteria);

        // Then
        $this->assertCount(2, $results);
        $this->assertEquals(
            $this->users->get('f3e56592-0bfd-4669-be39-6ac8ab5ac55f')->jsonSerialize(),
            $results->first()->jsonSerialize()
        );
        $this->assertEquals(
            $this->users->get('fe687d4a-a5fc-426b-ba15-13901bda54a6')->jsonSerialize(),
            $results->next()->jsonSerialize()
        );
    }
}
