<?php

declare(strict_types=1);

namespace Ifrost\EntityStorage\EntityFile;

use Ifrost\Filesystem\Directory;
use Ifrost\Filesystem\DirectoryInterface;
use Ifrost\Filesystem\JsonFile;
use Ifrost\Filesystem\JsonFileInterface;

class JsonEntityFileFactory implements JsonEntityFileFactoryInterface
{
    private DirectoryInterface $directory;

    public function __construct(private string $directoryPath)
    {
        $this->directory = new Directory($this->directoryPath);
    }

    public function getFile(string $filename): JsonFileInterface
    {
        return new JsonFile($filename);
    }

    public function getFileByUuid(string $uuid): JsonFileInterface
    {
        return new JsonFile($this->getFilename($uuid));
    }

    public function getDirectory(): DirectoryInterface
    {
        return $this->directory;
    }

    private function getFilename(string $uuid): string
    {
        return sprintf(
            '%s/%s.json',
            $this->directoryPath,
            $uuid
        );
    }
}
