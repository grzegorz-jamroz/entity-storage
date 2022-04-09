<?php

declare(strict_types=1);

namespace Tests\Variant;

use Ifrost\EntityStorage\Storage\JsonEntityStorage;

class UserStorage extends JsonEntityStorage
{
    public function __construct(string $directoryPath)
    {
        parent::__construct(User::class, $directoryPath);
    }
}
