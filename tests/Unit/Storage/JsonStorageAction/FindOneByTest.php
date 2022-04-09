<?php

declare(strict_types=1);

namespace Tests\Unit\Storage\JsonStorageAction;

use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;
use PHPUnit\Framework\TestCase;
use Ifrost\EntityStorage\Exception\EntityNotExist;
use Tests\Traits\JsonStorageAction\SetUp;
use Tests\Variant\User;

class FindOneByTest extends TestCase
{
    use SetUp;

    public function testShouldReturnOnlyOneResultWhenOnlyOneResultMatchCriteria()
    {
        // Given
        $criteria = new Criteria();
        $expr = new Comparison('email', Comparison::EQ, 'tom@email.com');
        $criteria->where($expr);

        // When
        $user = $this->testStorage->findOneBy($criteria);

        // Then
        $this->assertEquals(
            $this->users->get('f3e56592-0bfd-4669-be39-6ac8ab5ac55f')->jsonSerialize(),
            $user->jsonSerialize()
        );
    }

    public function testShouldReturnOnlyOneResultWhenMoreThanOneResultMatchCriteria()
    {
        // Given
        $criteria = new Criteria();
        $expr = new Comparison('countryLowerCase', Comparison::CONTAINS, 'kingdom');
        $criteria->where($expr);
        $criteria->orderBy(['surname' => Criteria::DESC]);

        // When
        $user = $this->testStorage->findOneBy($criteria);

        // Then
        $this->assertEquals(
            $this->users->get('fe687d4a-a5fc-426b-ba15-13901bda54a6')->jsonSerialize(),
            $user->jsonSerialize()
        );
    }

    public function testShouldThrowEntityNotExistWhenNoResultMatchCriteria()
    {
        // Expect
        $this->expectException(EntityNotExist::class);
        $this->expectExceptionMessage(sprintf('No %s found for the given criteria.', User::class));

        // Given
        $criteria = new Criteria();
        $expr = new Comparison('email', Comparison::EQ, 'superuser@email.com');
        $criteria->where($expr);

        // When & Then
        $this->testStorage->findOneBy($criteria);
    }
}
