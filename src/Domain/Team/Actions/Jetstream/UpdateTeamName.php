<?php

namespace Domain\Team\Actions\Jetstream;

use Domain\Team\Data\TeamUpdateData;
use Domain\Team\Models\Team;
use Domain\User\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Contracts\UpdatesTeamNames;

class UpdateTeamName implements UpdatesTeamNames
{
    /**
     * Validate and update the given team's name.
     *
     * @param  array<string, string>  $input
     */
    public function update(User $user, Team $team, TeamUpdateData $teamUpdateData): void
    {
        Gate::forUser($user)->authorize('update', $team);

        $team->forceFill([
            'name' => $teamUpdateData->name,
        ])->save();
    }
}
