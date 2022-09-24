<?php

declare(strict_types=1);

namespace Ifrost\EntityStorage\Entity;

use Ifrost\Foundations\ArrayConstructable;

interface EntityInterface extends ArrayConstructable, \JsonSerializable
{
    public function getUuid(): string;

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array;

    /**
     * @return array<int, string>
     */
    public static function getFields(): array;
}
