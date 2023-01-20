<?php

namespace Domain\Team\Data;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * @TODO - sort out casing
 */
class TeamPermissionsData extends Data
{
    public function __construct(
        public readonly bool $canAddTeamMembers,
        public readonly bool $canDeleteTeam,
        public readonly bool $canRemoveTeamMembers,
        public readonly bool $canUpdateTeam,
    ) {}
}
