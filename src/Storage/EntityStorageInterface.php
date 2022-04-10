<?php

declare(strict_types=1);

namespace Ifrost\EntityStorage\Storage;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Ifrost\EntityStorage\Entity\EntityInterface;
use Ifrost\EntityStorage\Exception\EntityAlreadyExists;
use Ifrost\EntityStorage\Exception\EntityNotExist;

interface EntityStorageInterface
{
    /**
     * @throws EntityNotExist
     */
    public function find(string $uuid): EntityInterface;

    /**
     * @throws EntityNotExist
     */
    public function findOneBy(Criteria $criteria): EntityInterface;

    /**
     * @return Collection<string, EntityInterface>
     */
    public function findAll(): Collection;

    /**
     * @return Collection<string, EntityInterface>
     */
    public function findBy(Criteria $criteria): Collection;

    /**
     * Creates a new entity if it does not exist.
     *
     * @throws EntityAlreadyExists
     */
    public function create(EntityInterface $entity): void;

    /**
     * Replaces the entire entity data with the given data.
     *
     * @throws EntityNotExist
     */
    public function update(EntityInterface $entity): void;

    /**
     * Only modifies selected fields.
     *
     * @param array<string, mixed> $data
     *
     * @throws EntityNotExist
     */
    public function modify(string $uuid, array $data): void;

    /**
     * Replaces the entire entity data with the given data.
     * Creates a new entity if it does not exist.
     */
    public function overwrite(EntityInterface $entity): void;

    public function delete(string $uuid): void;
}
