<?php

namespace Domain\User\Data;

use Illuminate\Contracts\Validation\Validator;
use Laravel\Fortify\Rules\Password;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Optional;

#[MapName(SnakeCaseMapper::class)]
class UserPasswordData extends Data
{
    public function __construct(
        public readonly string $password,
        public readonly string $currentPassword,
        public readonly string $passwordConfirmation,
    ) {}

    public static function withValidator(Validator $validator): void
    {
        $validator->validateWithBag('updatePassword');
    }

    public static function rules(): array
    {
        return [
            'current_password' => ['required', 'string', 'current_password:web'],
            'password' => ['required', 'string', new Password, 'confirmed'],
        ];
    }

    public static function messages(): array
    {
        return [
            'current_password.current_password' => __('The provided password does not match your current password.'),
        ];
    }
}
