<?php

declare(strict_types=1);

namespace Ifrost\EntityStorage\Storage\JsonStorageAction;

use Doctrine\Common\Collections\Criteria;
use Ifrost\EntityStorage\Entity\EntityFactory;
use Ifrost\EntityStorage\Entity\EntityInterface;
use Ifrost\EntityStorage\EntityFile\JsonEntityFileFactory;
use Ifrost\EntityStorage\Exception\EntityNotExist;
use Ifrost\Foundations\Acquirable;

class FindOneByAction implements Acquirable
{
    public function __construct(
        private EntityFactory $entityFactory,
        private JsonEntityFileFactory $fileFactory,
        private Criteria $criteria,
    ) {
    }

    /**
     * @throws EntityNotExist
     */
    public function acquire(): EntityInterface
    {
        $this->criteria->setMaxResults(1);
        $entities = (new FindByAction($this->entityFactory, $this->fileFactory, $this->criteria))->acquire();

        return $entities->first() ?: throw new EntityNotExist(sprintf('No %s found for the given criteria.', $this->entityFactory->getEntityClassName()));
    }
}
