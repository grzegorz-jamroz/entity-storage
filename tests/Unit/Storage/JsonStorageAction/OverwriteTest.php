<?php

declare(strict_types=1);

namespace Tests\Unit\Storage\JsonStorageAction;

use Ifrost\Filesystem\Directory;
use PHPUnit\Framework\TestCase;
use Tests\Traits\JsonStorageAction\SetUp;
use Tests\Variant\User;

class OverwriteTest extends TestCase
{
    use SetUp;

    public function testShouldCreateUserWhenUserNotExists()
    {
        // Expect & Given
        (new Directory($this->directoryPath))->delete();
        $this->assertDirectoryDoesNotExist($this->directoryPath);
        $uuid = 'f3e56592-0bfd-4669-be39-6ac8ab5ac55f';

        // When
        $this->storage->overwrite($this->users->get($uuid));

        // Then
        $this->assertCount(1, $this->storage->findAll());
    }

    public function testShouldUpdateAllUserDataWhenUserExists()
    {
        // Expect & Given
        (new Directory($this->directoryPath))->delete();
        $this->assertDirectoryDoesNotExist($this->directoryPath);
        $uuid = 'f3e56592-0bfd-4669-be39-6ac8ab5ac55f';
        /** @var User $user */
        $user = $this->users->get($uuid);
        $this->storage->create($user);
        $this->assertCount(1, $this->storage->findAll());
        $newUserData = [
            'uuid' => $uuid,
            'name' => 'Harry',
        ];

        // When
        $this->storage->overwrite(User::createFromArray($newUserData));

        // Then
        $this->assertCount(1, $this->storage->findAll());
        $this->assertEquals(
            [
                'uuid' => 'f3e56592-0bfd-4669-be39-6ac8ab5ac55f',
                'username' => '',
                'email' => '',
                'roles' => [],
                'name' => 'Harry',
                'surname' => '',
                'country' => '',
            ],
            $this->storage->find($uuid)->jsonSerialize()
        );
    }
}
