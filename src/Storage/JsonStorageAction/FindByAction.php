<?php

declare(strict_types=1);

namespace Ifrost\EntityStorage\Storage\JsonStorageAction;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Ifrost\EntityStorage\Entity\EntityFactory;
use Ifrost\EntityStorage\Entity\EntityInterface;
use Ifrost\EntityStorage\EntityFile\JsonEntityFileFactory;
use Ifrost\Foundations\Acquirable;

class FindByAction implements Acquirable
{
    public function __construct(
        private EntityFactory $entityFactory,
        private JsonEntityFileFactory $fileFactory,
        private Criteria $criteria,
    ) {
    }

    /**
     * @return Collection<string, EntityInterface>
     */
    public function acquire(): Collection
    {
        $entities = (new FindAllAction($this->entityFactory, $this->fileFactory))->acquire();

        return $entities->matching($this->criteria);
    }
}
