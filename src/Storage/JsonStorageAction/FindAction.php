<?php

declare(strict_types=1);

namespace Ifrost\EntityStorage\Storage\JsonStorageAction;

use Ifrost\EntityStorage\Entity\EntityFactory;
use Ifrost\EntityStorage\Entity\EntityInterface;
use Ifrost\EntityStorage\EntityFile\JsonEntityFileFactory;
use Ifrost\EntityStorage\Exception\EntityNotExist;
use Ifrost\Filesystem\File\Exception\FileNotExist;
use Ifrost\Foundations\Acquirable;

class FindAction implements Acquirable
{
    public function __construct(
        private string $uuid,
        private EntityFactory $entityFactory,
        private JsonEntityFileFactory $fileFactory,
    ) {
    }

    /**
     * @throws EntityNotExist
     */
    public function acquire(): EntityInterface
    {
        try {
            $file = $this->fileFactory->getFileByUuid($this->uuid);

            return $this->entityFactory->create($file->read());
        } catch (FileNotExist) {
            throw new EntityNotExist(sprintf('The entity "%s" with UUID "%s" does not exist.', $this->entityFactory->getEntityClassName(), $this->uuid));
        }
    }
}
