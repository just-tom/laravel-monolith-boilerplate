<?php

namespace Domain\Api\Data;

use Carbon\Carbon;
use Domain\Team\Data\TeamData;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Rules\Password;
use Laravel\Jetstream\Jetstream;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Optional;

#[MapName(SnakeCaseMapper::class)]
class ApiTokenData extends Data
{
    public function __construct(
        public readonly int | Optional $id,
        public readonly string $name,
        /** @var string[] $abilities */
        public readonly array $abilities,
        public readonly string | null $lastUsedAgo,
        public readonly string | null $lastUsedAt,
        public readonly int $tokenableId,
        public readonly string $tokenableType,
        public readonly ?Carbon $createdAt,
        public readonly ?Carbon $updatedAt,
    ) {}
}
