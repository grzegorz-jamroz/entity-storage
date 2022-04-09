<?php

declare(strict_types=1);

namespace Tests\Unit\Storage\JsonStorageAction;

use Ifrost\Filesystem\Directory;
use PHPUnit\Framework\TestCase;
use Ifrost\EntityStorage\Exception\EntityAlreadyExists;
use Tests\Traits\JsonStorageAction\SetUp;
use Tests\Variant\User;

class CreateTest extends TestCase
{
    use SetUp;

    public function testShouldCreateUserWhenUserNotExists()
    {
        // Expect & Given
        (new Directory($this->directoryPath))->delete();
        $this->assertDirectoryDoesNotExist($this->directoryPath);
        $uuid = 'f3e56592-0bfd-4669-be39-6ac8ab5ac55f';

        // When
        $this->storage->create($this->users->get($uuid));

        // Then
        $this->assertCount(1, $this->storage->findAll());
    }

    public function testShouldThrowEntityAlreadyExistsWhenUserAlreadyExists()
    {
        // Expect & Given
        $uuid = 'f3e56592-0bfd-4669-be39-6ac8ab5ac55f';
        $this->expectException(EntityAlreadyExists::class);
        $this->expectExceptionMessage(sprintf('The entity "%s" cannot be created because there is another item with the given UUID "%s".', User::class, $uuid));

        // When & Then
        $this->testStorage->create($this->users->get($uuid));
    }
}
