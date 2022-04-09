<?php

declare(strict_types=1);

namespace Ifrost\EntityStorage\Entity;

interface EntityFactoryInterface
{
    /**
     * @param array<string, mixed> $data
     */
    public function create(array $data): EntityInterface;

    public function getEntityClassName(): string;
}
