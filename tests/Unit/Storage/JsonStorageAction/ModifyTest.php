<?php

declare(strict_types=1);

namespace Tests\Unit\Storage\JsonStorageAction;

use Ifrost\Filesystem\Directory;
use PHPUnit\Framework\TestCase;
use Ifrost\EntityStorage\Exception\EntityNotExist;
use Tests\Traits\JsonStorageAction\SetUp;
use Tests\Variant\User;

class ModifyTest extends TestCase
{
    use SetUp;

    public function testShouldModifySelectedUserDataWhenUserExists()
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
            'name' => 'Harry',
        ];

        // When
        $this->storage->modify($uuid, $newUserData);

        // Then
        $this->assertCount(1, $this->storage->findAll());
        $this->assertEquals(
            [
                'uuid' => 'f3e56592-0bfd-4669-be39-6ac8ab5ac55f',
                'username' => 'tom',
                'email' => 'tom@email.com',
                'roles' => [
                    'ROLE_USER',
                ],
                'name' => 'Harry',
                'surname' => 'Baker',
                'country' => 'United Kingdom',
            ],
            $this->storage->find($uuid)->jsonSerialize()
        );
    }

    public function testShouldModifySelectedUserDataWhenUserExistsExceptUuid()
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
            'uuid' => '41c56456-6736-43c2-a262-e3867af04515',
            'email' => 'harry@email.com',
            'name' => 'Harry',
            'roles' => [
                'ROLE_ADMIN',
                'ROLE_USER',
            ],
        ];

        // When
        $this->storage->modify($uuid, $newUserData);

        // Then
        $this->assertCount(1, $this->storage->findAll());
        $this->assertEquals(
            [
                'uuid' => 'f3e56592-0bfd-4669-be39-6ac8ab5ac55f',
                'username' => 'tom',
                'email' => 'harry@email.com',
                'roles' => [
                    'ROLE_ADMIN',
                    'ROLE_USER',
                ],
                'name' => 'Harry',
                'surname' => 'Baker',
                'country' => 'United Kingdom',
            ],
            $this->storage->find($uuid)->jsonSerialize()
        );
    }

    public function testShouldThrowEntityNotExistWhenUserNotExist()
    {
        // Expect & Given
        $uuid = '41c56456-6736-43c2-a262-e3867af04515';
        $this->expectException(EntityNotExist::class);
        $this->expectExceptionMessage(sprintf('The entity "%s" with UUID "%s" does not exist.', User::class, $uuid));

        (new Directory($this->directoryPath))->delete();
        $this->assertDirectoryDoesNotExist($this->directoryPath);
        $this->assertCount(0, $this->storage->findAll());
        $newUserData = [
            'name' => 'Harry',
        ];

        // When & Then
        $this->storage->modify($uuid, $newUserData);
    }
}
