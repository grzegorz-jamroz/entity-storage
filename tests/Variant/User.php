<?php

declare(strict_types=1);

namespace Tests\Variant;

use PlainDataTransformer\Transform;
use Ifrost\EntityStorage\Entity\EntityInterface;

class User implements EntityInterface
{
    /**
     * @param array<int, string> $roles
     */
    public function __construct(
        private string $uuid,
        private string $username,
        private string $email,
        private array $roles,
        private string $name,
        private string $surname,
        private string $country,
    ) {
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getCountryLowerCase(): string
    {
        return strtolower($this->country);
    }

    /**
     * @return array<int, string>
     */
    public static function getFields(): array
    {
        return array_keys(self::createFromArray([])->jsonSerialize());
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'uuid' => $this->uuid,
            'username' => $this->username,
            'email' => $this->email,
            'roles' => $this->roles,
            'name' => $this->name,
            'surname' => $this->surname,
            'country' => $this->country,
        ];
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function createFromArray(array $data): self
    {
        /** @var array<int, string> $roles */
        $roles = Transform::toArray($data['roles'] ?? []);

        return new self(
            Transform::toString($data['uuid'] ?? ''),
            Transform::toString($data['username'] ?? ''),
            Transform::toString($data['email'] ?? ''),
            $roles,
            Transform::toString($data['name'] ?? ''),
            Transform::toString($data['surname'] ?? ''),
            Transform::toString($data['country'] ?? ''),
        );
    }
}
