<?php

declare(strict_types=1);

namespace Ifrost\EntityStorage\EntityFile;

use Ifrost\Filesystem\JsonFileInterface;

interface JsonEntityFileFactoryInterface extends EntityFileFactoryInterface
{
    public function getFile(string $filename): JsonFileInterface;

    public function getFileByUuid(string $uuid): JsonFileInterface;
}
