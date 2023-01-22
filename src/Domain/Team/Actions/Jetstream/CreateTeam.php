<?php

namespace Domain\Team\Actions\Jetstream;

use Domain\Team\Data\TeamCreateData;
use Domain\Team\Models\Team;
use Domain\User\Models\User;
use Illuminate\Support\Facades\Gate;
use Laravel\Jetstream\Events\AddingTeam;
use Laravel\Jetstream\Jetstream;

class CreateTeam
{
    public function create(User $user, TeamCreateData $teamData): Team
    {
        Gate::forUser($user)->authorize('create', Jetstream::newTeamModel());

        AddingTeam::dispatch($user);

        $user->switchTeam($team = $user->ownedTeams()->create([
            'name' => $teamData->name,
            'personal_team' => false,
        ]));

        return $team;
    }
}
