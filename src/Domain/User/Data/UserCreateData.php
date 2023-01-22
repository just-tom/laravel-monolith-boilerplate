<?php

namespace Domain\User\Data;

use Carbon\Carbon;
use Domain\Team\Data\TeamData;
use Domain\Team\Data\TeamMemberData;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Rules\Password;
use Laravel\Jetstream\Jetstream;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Optional;

#[MapName(SnakeCaseMapper::class)]
class UserCreateData extends Data
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
        public readonly string $passwordConfirmation,
        /** @var bool|string[] $terms */
        public readonly bool | Optional $terms,
        /** @var bool|string[] $remember */
        public readonly bool | Optional $remember,
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
