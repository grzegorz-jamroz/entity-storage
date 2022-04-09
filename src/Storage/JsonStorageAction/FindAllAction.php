<?php

declare(strict_types=1);

namespace Ifrost\EntityStorage\Storage\JsonStorageAction;

use Doctrine\Common\Collections\ArrayCollection;
use Ifrost\EntityStorage\Entity\EntityFactory;
use Ifrost\EntityStorage\Entity\EntityInterface;
use Ifrost\EntityStorage\EntityFile\JsonEntityFileFactory;
use Ifrost\Filesystem\Directory\Exception\DirectoryNotExist;
use Ifrost\Filesystem\File\Exception\FileNotExist;
use Ifrost\Foundations\Acquirable;

class FindAllAction implements Acquirable
{
    public function __construct(
        private EntityFactory $entityFactory,
        private JsonEntityFileFactory $fileFactory,
    ) {
    }

    /**
     * @return ArrayCollection<string, EntityInterface>
     */
    public function acquire(): ArrayCollection
    {
        $collection = new ArrayCollection();

        try {
            $filenames = $this->fileFactory->getDirectory()->getFiles(['extension' => 'json']);
        } catch (DirectoryNotExist) {
            return $collection;
        }

        foreach ($filenames as $filename) {
            try {
                $entity = $this->entityFactory->create($this->fileFactory->getFile($filename)->read());
                $collection->set($entity->getUuid(), $entity);
            } catch (FileNotExist) {
            }
        }

        return $collection;
    }
}
