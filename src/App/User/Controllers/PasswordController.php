<?php
declare(strict_types=1);

namespace App\User\Controllers;

use Domain\User\Actions\Fortify\UpdateUserPassword;
use Domain\User\Data\UserPasswordData;
use Laravel\Fortify\Contracts\PasswordUpdateResponse;

class PasswordController extends \App\Controller
{
    public function update(UserPasswordData $userPasswordData, UpdateUserPassword $updateUserPassword)
    {
        $updateUserPassword->update($userPasswordData);

        return app(PasswordUpdateResponse::class);
    }
}

