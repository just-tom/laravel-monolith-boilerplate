<?php

namespace App\Team\Controllers;

use App\Controller;
use Domain\Team\Actions\Jetstream\CreateTeam;
use Domain\Team\Actions\Jetstream\UpdateTeamName;
use Domain\Team\Data\TeamCreateData;
use Domain\Team\Data\TeamData;
use Domain\Team\Data\TeamUpdateData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Laravel\Jetstream\Actions\ValidateTeamDeletion;
use Laravel\Jetstream\Contracts\CreatesTeams;
use Laravel\Jetstream\Contracts\DeletesTeams;
use Laravel\Jetstream\Contracts\UpdatesTeamNames;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\RedirectsActions;

class TeamController extends Controller
{
    use RedirectsActions;

    public function show(Request $request, $teamId)
    {
        $team = Jetstream::newTeamModel()->findOrFail($teamId);

        Gate::authorize('view', $team);

        return Jetstream::inertia()->render($request, 'Teams/Show', [
            'team' => TeamData::from($team->load('owner', 'users', 'teamInvitations')),
            'availableRoles' => array_values(Jetstream::$roles),
            'availablePermissions' => Jetstream::$permissions,
            'defaultPermissions' => Jetstream::$defaultPermissions,
        ]);
    }

    public function store(TeamCreateData $teamCreateData, Request $request, CreateTeam $createTeam)
    {
        return $this->redirectPath(
            TeamData::from($createTeam->create($request->user(), $teamCreateData))
        );
    }

    public function update(TeamUpdateData $teamData, Request $request, UpdateTeamName $updateTeamName, $teamId)
    {
        $team = Jetstream::newTeamModel()->findOrFail($teamId);

        $updateTeamName->update($request->user(), $team, $teamData);

        return back(303);
    }

}
