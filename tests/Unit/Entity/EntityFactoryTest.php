<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use Ifrost\EntityStorage\Entity\EntityFactory;
use Ifrost\EntityStorage\Entity\EntityInterface;
use Tests\Variant\Sample;

class EntityFactoryTest extends TestCase
{
    public function testShouldThrowInvalidArgumentExceptionWhenEntityClassNameNotRepresentEntityInterface()
    {
        // Expect
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('Given argument entityClassName (%s) has to implement "%s" interface.', Sample::class, EntityInterface::class));

        // When & Then
        new EntityFactory(Sample::class);
    }
}
