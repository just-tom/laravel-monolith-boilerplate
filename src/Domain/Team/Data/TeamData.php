<?php

namespace Domain\Team\Data;

use Domain\Team\Models\Team;
use Domain\User\Data\UserData;
use Domain\User\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Momentum\Lock\Data\DataResource;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Optional;

#[MapName(SnakeCaseMapper::class)]

class TeamData extends DataResource
{
    protected string $modelClass = Team::class;

    public function __construct(
        public readonly string | Optional $id,
        public readonly string $name,
        public readonly bool $personalTeam,
        public readonly UserData $owner,
        /** @var DataCollection<UserData> */
        public readonly DataCollection $users,
        /** @var DataCollection<TeamInvitationData> */
        public readonly DataCollection $teamInvitations,
    ) {}

    public static function withValidator(Validator $validator): void
    {
        $validator->validateWithBag('createTeam');
    }

    public static function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
        ];
    }

    public static function fromRequest(Request $request): self
    {
        return self::from([
            ...$request->all(),
            'owner' => UserData::from(User::find($request->user_id)),
        ]);
    }

    public static function fromModel(Team $team): self
    {
        return self::from([
            ...$team->toArray(),
            'owner' => UserData::from(User::find($team->user_id)),
            'users' => UserData::collection($team->users),
            'team_invitations' => TeamInvitationData::collection($team->teamInvitations)
        ]);
    }
}
