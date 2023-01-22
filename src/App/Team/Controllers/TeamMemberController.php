<?php
declare(strict_types=1);

namespace App\Team\Controllers;

use App\Controller;
use Domain\Team\Data\TeamInvitationData;
use Domain\Team\Data\TeamMemberData;
use Illuminate\Http\Request;
use Laravel\Jetstream\Actions\UpdateTeamMemberRole;
use Laravel\Jetstream\Contracts\AddsTeamMembers;
use Laravel\Jetstream\Contracts\InvitesTeamMembers;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Jetstream;

class TeamMemberController extends Controller
{
    public function store(Request $request, TeamInvitationData $teamInvitationData, $teamId)
    {
        $team = Jetstream::newTeamModel()->findOrFail($teamId);

        if (Features::sendsTeamInvitations()) {
            app(InvitesTeamMembers::class)->invite(
                $request->user(),
                $team,
                $teamInvitationData->email ?: '',
                $teamInvitationData->role
            );
        } else {
            app(AddsTeamMembers::class)->add(
                $request->user(),
                $team,
                $teamInvitationData->email ?: '',
                $teamInvitationData->role
            );
        }

        return back(303);
    }

    public function update(Request $request, TeamMemberData $teamMemberData, $teamId, $userId)
    {
        app(UpdateTeamMemberRole::class)->update(
            $request->user(),
            Jetstream::newTeamModel()->findOrFail($teamId),
            $userId,
            $teamMemberData->role
        );

        return back(303);
    }
}
