<?php

namespace Domain\Team\Data;

use Carbon\Carbon;
use Domain\User\Data\UserData;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Optional;

#[MapName(SnakeCaseMapper::class)]
class TeamMemberData extends Data
{
    public function __construct(
        public readonly int | Optional $teamId,
        public readonly int | Optional $userId,
        public readonly string $role,
    ) {}
}
