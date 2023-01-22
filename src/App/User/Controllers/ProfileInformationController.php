<?php
declare(strict_types=1);

namespace App\User\Controllers;

use App\Controller;
use Domain\User\Actions\Fortify\UpdateUserProfileInformation;
use Domain\User\Data\UserUpdateData;
use Laravel\Fortify\Contracts\ProfileInformationUpdatedResponse;

class ProfileInformationController extends Controller
{
    public function update(UserUpdateData $userRequestData, UpdateUserProfileInformation $updateUserProfileInformation)
    {
        $updateUserProfileInformation->update($userRequestData);

        return app(ProfileInformationUpdatedResponse::class);
    }
}
