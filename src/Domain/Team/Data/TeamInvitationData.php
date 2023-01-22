<?php

namespace Domain\Team\Data;

use Carbon\Carbon;
use Domain\Team\Models\Team;
use Domain\User\Data\UserData;
use Domain\User\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Rules\Role;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Optional;

#[MapName(SnakeCaseMapper::class)]
class TeamInvitationData extends Data
{
    public function __construct(
        public readonly int | Optional $id,
        public readonly ?int $teamId,
        public readonly string $email,
        public readonly string $role,
    ) {}

    public static function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                Rule::unique('team_invitations')->where(function (Builder $query) {
                    $team = Team::find(request('team'));
                    $query->where('team_id', $team->id);
                })
            ],
            'role' => Jetstream::hasRoles()
                ? ['required', 'string', new Role]
                : null,
        ];
    }

    public static function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $validator->errors()->addIf(
                (Team::find(request('team')))->hasUserWithEmail(request('email')),
                'email',
                __('This user already belongs to the team.')
            );
        });
    }

    public static function messages(): array
    {
        return [
            'email.exists' => __('We were unable to find a registered user with this email address.'),
        ];
    }
}
