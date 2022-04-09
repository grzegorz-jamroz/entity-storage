<?php

declare(strict_types=1);

namespace Tests\Unit\Storage\JsonStorageAction;

use Ifrost\Filesystem\Directory;
use PHPUnit\Framework\TestCase;
use Tests\Variant\User;
use Tests\Traits\JsonStorageAction\SetUp;

class FindAllTest extends TestCase
{
    use SetUp;

    public function testShouldReturnEmptyArrayWhenThereAreNoUsersAndStorageDirectoryDoesNotExist()
    {
        // Expect & Given
        (new Directory($this->directoryPath))->delete();
        $this->assertDirectoryDoesNotExist($this->directoryPath);

        // When
        $users = $this->storage->findAll();

        // Then
        $this->assertEquals(0, $users->count());
        $this->assertDirectoryDoesNotExist($this->directoryPath);
    }

    public function testShouldReturnOneUserWhenOnlyOneUserExists()
    {
        // Expect & Given
        (new Directory($this->directoryPath))->delete();
        $this->assertDirectoryDoesNotExist($this->directoryPath);
        $this->createDirectoryIfNotExists($this->directoryPath);
        /** @var User $user */
        $user = $this->users->first();
        $this->storage->create($user);
        $this->assertFileExists(sprintf('%s/8b40a6d6-1a79-4edc-bfca-0f8d993c29f3.json', $this->testDirectoryPath));

        // When
        $users = $this->storage->findAll();

        // Then
        $this->assertCount(1, $users);
        $this->assertInstanceOf(User::class, $users->first());
    }

    public function testShouldReturnThreeUsersWhenOnlyThreeUsersExist()
    {
        // Expect & Given
        (new Directory($this->directoryPath))->delete();
        $this->assertDirectoryDoesNotExist($this->directoryPath);
        $this->createDirectoryIfNotExists($this->directoryPath);

        /** @var User $user */
        foreach ($this->users as $user) {
            $this->storage->create($user);
        }

        // When
        $users = $this->storage->findAll();

        // Then
        $this->assertCount(3, $users);
    }
}
