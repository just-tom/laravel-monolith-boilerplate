<?php

namespace App\Providers;

use Domain\Team\Actions\Jetstream\AddTeamMember;
use Domain\Team\Actions\Jetstream\CreateTeam;
use Domain\Team\Actions\Jetstream\DeleteTeam;
use Domain\Team\Actions\Jetstream\InviteTeamMember;
use Domain\Team\Actions\Jetstream\RemoveTeamMember;
use Domain\Team\Actions\Jetstream\UpdateTeamName;
use Domain\User\Actions\Jetstream\DeleteUser;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configurePermissions();

        Jetstream::useUserModel('Domain\User\Models\User');
        Jetstream::useTeamModel('Domain\Team\Models\Team');
        Jetstream::useMembershipModel('Domain\Team\Models\Membership');
        Jetstream::useTeamInvitationModel('Domain\Team\Models\TeamInvitation');

        Jetstream::createTeamsUsing(CreateTeam::class);
        Jetstream::updateTeamNamesUsing(UpdateTeamName::class);
        Jetstream::addTeamMembersUsing(AddTeamMember::class);
        Jetstream::inviteTeamMembersUsing(InviteTeamMember::class);
        Jetstream::removeTeamMembersUsing(RemoveTeamMember::class);
        Jetstream::deleteTeamsUsing(DeleteTeam::class);
        Jetstream::deleteUsersUsing(DeleteUser::class);
    }

    /**
     * Configure the roles and permissions that are available within the application.
     */
    protected function configurePermissions(): void
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::role('admin', 'Administrator', [
            'create',
            'read',
            'update',
            'delete',
        ])->description('Administrator users can perform any action.');

        Jetstream::role('editor', 'Editor', [
            'read',
            'create',
            'update',
        ])->description('Editor users have the ability to read, create, and update.');
    }
}
