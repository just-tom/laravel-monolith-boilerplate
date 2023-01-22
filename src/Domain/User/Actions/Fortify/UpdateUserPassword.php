<?php

namespace Domain\User\Actions\Fortify;

use Domain\User\Data\UserPasswordData;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

class UpdateUserPassword implements UpdatesUserPasswords
{
    public function update(UserPasswordData $userPasswordData): void
    {
        request()->user()->forceFill([
            'password' => Hash::make($userPasswordData->password),
        ])->save();
    }
}
