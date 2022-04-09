<?php

declare(strict_types=1);

namespace Ifrost\EntityStorage\EntityFile;

use Ifrost\Filesystem\DirectoryInterface;
use Ifrost\Filesystem\FileInterface;

interface EntityFileFactoryInterface
{
    public function getFile(string $filename): FileInterface;

    public function getFileByUuid(string $uuid): FileInterface;

    public function getDirectory(): DirectoryInterface;
}
