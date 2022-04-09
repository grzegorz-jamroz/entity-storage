<?php

declare(strict_types=1);

namespace Tests\Unit\Storage\JsonStorageAction;

use Ifrost\Filesystem\Directory;
use PHPUnit\Framework\TestCase;
use Ifrost\EntityStorage\Exception\EntityNotExist;
use Tests\Traits\JsonStorageAction\SetUp;
use Tests\Variant\User;

class FindTest extends TestCase
{
    use SetUp;

    public function testShouldReturnUserWhenUserForGivenUuidExists()
    {
        // Expect & Given
        (new Directory($this->directoryPath))->delete();
        $this->assertDirectoryDoesNotExist($this->directoryPath);
        $this->createDirectoryIfNotExists($this->directoryPath);

        /** @var User $user */
        foreach ($this->users as $user) {
            $this->storage->create($user);
            $this->assertFileExists(sprintf('%s/%s.json', $this->testDirectoryPath, $user->getUuid()));
        }

        // When
        $user = $this->storage->find('8b40a6d6-1a79-4edc-bfca-0f8d993c29f3');

        // Then
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('max@email.com', $user->getEmail());
    }

    public function testShouldThrowEntityNotExistWhenUserForGivenUuidDoesNotExist()
    {
        // Expect & Given
        $uuid = '8b40a6d6-1a79-4edc-bfca-0f8d993c29f3';
        $this->expectException(EntityNotExist::class);
        $this->expectExceptionMessage(sprintf('The entity "%s" with UUID "%s" does not exist.', User::class, $uuid));
        (new Directory($this->directoryPath))->delete();
        $this->assertDirectoryDoesNotExist($this->directoryPath);

        // When
        $this->storage->find($uuid);
    }
}
