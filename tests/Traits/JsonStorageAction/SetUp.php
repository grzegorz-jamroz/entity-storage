<?php

declare(strict_types=1);

namespace Tests\Traits\JsonStorageAction;

use Doctrine\Common\Collections\ArrayCollection;
use Ifrost\Filesystem\JsonFile;
use Tests\Variant\User;
use Tests\Traits\TestUtils;
use Tests\Variant\UserStorage;

trait SetUp
{
    use TestUtils;

    private string $directoryPath;
    private string $testDirectoryPath;
    private UserStorage $storage;
    private UserStorage $testStorage;

    /**
     * @var ArrayCollection<string, User>
     */
    private ArrayCollection $users;

    protected function setUp(): void
    {
        $this->directoryPath = sprintf('%s/users', DATA_DIRECTORY);
        $this->testDirectoryPath = sprintf('%s/users', TESTS_DATA_DIRECTORY);
        $this->storage = new UserStorage($this->directoryPath);
        $this->testStorage = new UserStorage($this->testDirectoryPath);
        $this->users = array_reduce(
            [
                '8b40a6d6-1a79-4edc-bfca-0f8d993c29f3',
                'f3e56592-0bfd-4669-be39-6ac8ab5ac55f',
                'fe687d4a-a5fc-426b-ba15-13901bda54a6',
            ],
            function (ArrayCollection $acc, string $uuid) {
                $userData = (new JsonFile(sprintf('%s/%s.json', $this->testDirectoryPath, $uuid)))->read();
                $acc->set($uuid, User::createFromArray($userData));

                return $acc;
            },
            new ArrayCollection()
        );
    }
}
