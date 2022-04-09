<?php

declare(strict_types=1);

namespace Ifrost\EntityStorage\Entity;

use PlainDataTransformer\Transform;

class EntityFactory implements EntityFactoryInterface
{
    private string $entityClassName;

    /**
     * @template T of EntityInterface
     *
     * @param class-string<T> $entityClassName
     */
    public function __construct(
        string $entityClassName
    ) {
        $this->setEntityClassName($entityClassName);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function create(array $data): EntityInterface
    {
        return $this->entityClassName::createFromArray($data);
    }

    public function getEntityClassName(): string
    {
        return $this->entityClassName;
    }

    private function setEntityClassName(string $entityClassName): void
    {
        if (!in_array(EntityInterface::class, Transform::toArray(class_implements($entityClassName)))) {
            throw new \InvalidArgumentException(sprintf('Given argument entityClassName (%s) has to implement "%s" interface.', $entityClassName, EntityInterface::class));
        }

        $this->entityClassName = $entityClassName;
    }
}
