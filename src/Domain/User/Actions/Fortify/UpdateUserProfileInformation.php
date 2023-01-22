<?php

namespace Domain\User\Actions\Fortify;

use Domain\User\Data\UserUpdateData;
use Domain\User\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class UpdateUserProfileInformation
{
    public function update(UserUpdateData $userUpdateData): void
    {
        $user = request()->user();
        if (isset($input->photo)) {
            $user->updateProfilePhoto($userUpdateData->photo);
        }

        if ($userUpdateData->email !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $userUpdateData);
        } else {
            $user->forceFill([
                'name' => $userUpdateData->name,
                'email' => $userUpdateData->email,
            ])->save();
        }
    }

    protected function updateVerifiedUser(User $user, UserUpdateData $userUpdateData): void
    {
        $user->forceFill([
            'name' => $userUpdateData->name,
            'email' => $userUpdateData->email,
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
