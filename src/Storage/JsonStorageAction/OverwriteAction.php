<?php

declare(strict_types=1);

namespace Ifrost\EntityStorage\Storage\JsonStorageAction;

use Ifrost\EntityStorage\EntityFile\JsonEntityFileFactory;
use Ifrost\EntityStorage\Exception\EntityNotExist;
use Ifrost\Foundations\Executable;

class OverwriteAction implements Executable
{
    /**
     * @param array<string, mixed> $data
     */
    public function __construct(
        private string $uuid,
        private array $data,
        private JsonEntityFileFactory $fileFactory,
    ) {
    }

    /**
     * @throws EntityNotExist
     */
    public function execute(): void
    {
        $this->data['uuid'] = $this->uuid;
        $this->fileFactory->getFileByUuid($this->uuid)->overwrite($this->data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}
