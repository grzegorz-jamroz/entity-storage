<?php

declare(strict_types=1);

namespace Ifrost\EntityStorage\Storage;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Ifrost\EntityStorage\Entity\EntityFactory;
use Ifrost\EntityStorage\Entity\EntityInterface;
use Ifrost\EntityStorage\EntityFile\JsonEntityFileFactory;
use Ifrost\EntityStorage\Exception\EntityNotExist;
use Ifrost\EntityStorage\Storage\JsonStorageAction as Action;

abstract class JsonEntityStorage implements EntityStorageInterface
{
    private EntityFactory $entityFactory;
    private JsonEntityFileFactory $fileFactory;

    /**
     * @template T of EntityInterface
     *
     * @param class-string<T> $entityClassName
     */
    public function __construct(
        string $entityClassName,
        string $directoryPath,
    ) {
        $this->entityFactory = new EntityFactory($entityClassName);
        $this->fileFactory = new JsonEntityFileFactory($directoryPath);
    }

    /**
     * @throws EntityNotExist
     */
    public function find(string $uuid): EntityInterface
    {
        return (new Action\FindAction(
            $uuid,
            $this->entityFactory,
            $this->fileFactory
        ))->acquire();
    }

    /**
     * @throws EntityNotExist
     */
    public function findOneBy(Criteria $criteria): EntityInterface
    {
        return (new Action\FindOneByAction(
            $this->entityFactory,
            $this->fileFactory,
            $criteria
        ))->acquire();
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): Collection
    {
        return (new Action\FindAllAction(
            $this->entityFactory,
            $this->fileFactory
        ))->acquire();
    }

    /**
     * {@inheritdoc}
     */
    public function findBy(Criteria $criteria): Collection
    {
        return (new Action\FindByAction(
            $this->entityFactory,
            $this->fileFactory,
            $criteria
        ))->acquire();
    }

    /**
     * {@inheritdoc}
     */
    public function create(EntityInterface $entity): void
    {
        (new Action\CreateAction(
            $entity->getUuid(),
            $entity->jsonSerialize(),
            $this->entityFactory,
            $this->fileFactory
        ))->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function update(EntityInterface $entity): void
    {
        (new Action\UpdateAction(
            $entity->getUuid(),
            $entity->jsonSerialize(),
            $this->entityFactory,
            $this->fileFactory
        ))->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function modify(string $uuid, array $data): void
    {
        (new Action\ModifyAction(
            $uuid,
            $data,
            $this->entityFactory,
            $this->fileFactory
        ))->execute();
    }

    public function delete(string $uuid): void
    {
        $this->fileFactory->getFileByUuid($uuid)->delete();
    }
}
