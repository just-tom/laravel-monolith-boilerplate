<?php

namespace Domain\Team\Data;

use Carbon\Carbon;
use Domain\User\Data\UserData;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class TeamMemberData extends Data
{
    public function __construct(
        public readonly int $teamId,
        public readonly int $userId,
        public readonly string $role,
        public readonly Carbon $createdAt,
        public readonly Carbon $updatedAt
    ) {}
}
