<?php
declare(strict_types=1);

namespace App\User\Controllers;

use Domain\User\Data\SessionData;
use Illuminate\Http\Request;
use Laravel\Jetstream\Http\Controllers\Inertia\UserProfileController as JetstreamUserProfileController;

class UserProfileController extends JetstreamUserProfileController
{
    /** @return SessionData::collection */
    public function sessions(Request $request)
    {
        return SessionData::collection(parent::sessions($request));
    }
}
