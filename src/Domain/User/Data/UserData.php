<?php

namespace Domain\User\Data;

use Carbon\Carbon;
use Domain\Team\Data\TeamData;
use Domain\Team\Data\TeamMemberData;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Rules\Password;
use Laravel\Jetstream\Jetstream;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
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
        public readonly string $password,
        public readonly string $profilePhotoUrl,
        public readonly string $profilePhotoPath,
        public readonly string $passwordConfirmation,
        public readonly string $currentPassword,
        public readonly ?TeamData $currentTeam,
        /** @var DataCollection<TeamData> */
        public readonly ?DataCollection $allTeams,
        public readonly ?bool $twoFactorEnabled,
        /** @var bool|string[] $terms */
        public readonly bool $terms,
        /** @var bool|string[] $remember */
        public readonly bool $remember,
        public readonly TeamMemberData | Optional $membership,
        public readonly ?Carbon $createdAt,
        public readonly ?Carbon $updatedAt
    ) {}

    public static function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore(request('user')),
            ],
            'password' => ['required', 'string', new Password, 'confirmed'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ];
    }
}
