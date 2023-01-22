<?php

namespace Domain\User\Actions\Fortify;

use Domain\User\Data\UserCreateData;
use Domain\User\Models\User;
use Domain\Team\Models\Team;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateNewUser
{
    use PasswordValidationRules;

    public function create(UserCreateData $userData): User
    {
        return DB::transaction(function () use ($userData) {
            return tap(User::create([
                ...$userData->all(),
                'password' => Hash::make($userData->password),
            ]), function (User $user) {
                $this->createTeam($user);
            });
        });
    }

    /**
     * Create a personal team for the user.
     */
    protected function createTeam(User $user): void
    {
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]));
    }
}
