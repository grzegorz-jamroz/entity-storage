<?php

declare(strict_types=1);

namespace Tests\Unit\Storage\JsonStorageAction;

use Ifrost\Filesystem\Directory;
use PHPUnit\Framework\TestCase;
use Tests\Traits\JsonStorageAction\SetUp;

class DeleteTest extends TestCase
{
    use SetUp;

    public function testShouldDeleteUserWhenExists()
    {
        // Expect & Given
        (new Directory($this->directoryPath))->delete();
        $this->assertDirectoryDoesNotExist($this->directoryPath);
        $this->createDirectoryIfNotExists($this->directoryPath);
        $uuid = 'f3e56592-0bfd-4669-be39-6ac8ab5ac55f';
        $this->storage->create($this->users->get($uuid));
        $this->assertCount(1, $this->storage->findAll());

        // When
        $this->storage->delete($uuid);

        // Then
        $this->assertCount(0, $this->storage->findAll());
    }

    public function testShouldTryDeleteNotExistingUserAndNothingShouldHappen()
    {
        // Expect & Given
        $uuid = 'f3e56592-0bfd-4669-be39-6ac8ab5ac55f';
        (new Directory($this->directoryPath))->delete();
        $this->assertDirectoryDoesNotExist($this->directoryPath);
        $this->assertCount(0, $this->storage->findAll());

        // When
        $this->storage->delete($uuid);

        // Then
        $this->assertCount(0, $this->storage->findAll());
    }
}
