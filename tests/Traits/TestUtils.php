<?php

declare(strict_types=1);

namespace Tests\Traits;

use Ifrost\Filesystem\Directory;
use Ifrost\Filesystem\Directory\Exception\DirectoryAlreadyExists;
use Ifrost\Filesystem\File\Exception\FileAlreadyExists;
use Ifrost\Filesystem\TextFile;

trait TestUtils
{
    protected function createFileIfNotExists(string $filename, string $content = ''): void
    {
        try {
            (new TextFile($filename))->create($content);
        } catch (FileAlreadyExists) {
        }
    }

    protected function createDirectoryIfNotExists(
        string $directoryPath,
        int $permissions = 0777,
        bool $recursive = true
    ): void {
        try {
            (new Directory($directoryPath))->create($permissions, $recursive);
        } catch (DirectoryAlreadyExists) {
        }
    }
}
