<?php

namespace Domain\User\Data;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class RoleData extends Data
{
    public function __construct(
        public readonly string $key,
        public readonly string $name,
        /** @var string[] $permissions */
        public readonly array $permissions,
        public readonly string $description,
    ) {}
}
