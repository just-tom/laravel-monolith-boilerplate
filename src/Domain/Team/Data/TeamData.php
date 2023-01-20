<?php

namespace Domain\Team\Data;

use Carbon\Carbon;
use Domain\User\Data\UserData;
use Domain\User\Models\User;
use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Optional;

#[MapName(SnakeCaseMapper::class)]

class TeamData extends Data
{
    public function __construct(
        public readonly int | Optional $id,
        public readonly UserData $owner,
        public readonly string $name,
        public readonly bool $personalTeam,
        /** @var DataCollection<UserData> */
        public readonly DataCollection $users,
        /** @var DataCollection<TeamInvitationData> */
        public readonly DataCollection $teamInvitations,
        public readonly ?Carbon $createdAt,
        public readonly ?Carbon $updatedAt
    ) {}

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
}
