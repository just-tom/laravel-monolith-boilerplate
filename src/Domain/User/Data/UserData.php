<?php

namespace Domain\User\Data;

use Carbon\Carbon;
use Domain\Team\Data\TeamData;
use Domain\Team\Data\TeamMemberData;
use Domain\User\Models\User;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Rules\Password;
use Laravel\Jetstream\Jetstream;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Optional;

#[MapName(SnakeCaseMapper::class)]

class UserData extends Data
{
    public function __construct(
        public readonly int | Optional $id,
        public readonly string $name,
        public readonly string $email,
        public readonly ?string $emailVerifiedAt,
        public readonly string | Lazy $profilePhotoUrl,
        public readonly string | Lazy $profilePhotoPath,
        public readonly ?TeamData $currentTeam,
        /** @var DataCollection<TeamData> */
        public readonly ?DataCollection $allTeams,
        public readonly ?bool $twoFactorEnabled,
        public readonly TeamMemberData | Lazy $membership,
        /** @var bool|string[] $remember */
        public readonly ?bool $remember,
        public readonly ?Carbon $createdAt,
        public readonly ?Carbon $updatedAt
    ) {}

    public static function fromModel(User $user) : self
    {
        return new self(
            $user->id,
            $user->name,
            $user->email,
            $user->email_verified_at,
            Lazy::inertia(fn() => $user->profile_photo_url),
            Lazy::inertia(fn() => $user->profile_photo_path),
            $user->current_team,
            $user->all_teams,
            $user->two_factor_enabled,
            Lazy::inertia(fn() => $user->membership),
            $user->remember,
            $user->created_at,
            $user->updated_at,
        );
    }
}
