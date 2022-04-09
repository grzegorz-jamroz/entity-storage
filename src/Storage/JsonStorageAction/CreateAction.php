<?php

declare(strict_types=1);

namespace Ifrost\EntityStorage\Storage\JsonStorageAction;

use Ifrost\EntityStorage\Entity\EntityFactory;
use Ifrost\EntityStorage\EntityFile\JsonEntityFileFactory;
use Ifrost\EntityStorage\Exception\EntityAlreadyExists;
use Ifrost\Filesystem\File\Exception\FileAlreadyExists;
use Ifrost\Foundations\Executable;

class CreateAction implements Executable
{
    /**
     * @param array<string, mixed> $data
     */
    public function __construct(
        private string $uuid,
        private array $data,
        private EntityFactory $entityFactory,
        private JsonEntityFileFactory $fileFactory,
    ) {
    }

    /**
     * @throws EntityAlreadyExists
     */
    public function execute(): void
    {
        try {
            $this->fileFactory->getFileByUuid($this->uuid)->create($this->data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        } catch (FileAlreadyExists) {
            throw new EntityAlreadyExists(sprintf('The entity "%s" cannot be created because there is another item with the given UUID "%s".', $this->entityFactory->getEntityClassName(), $this->uuid));
        }
    }
}
