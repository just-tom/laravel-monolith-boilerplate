<?php
declare(strict_types=1);

namespace App\User\Controllers;

use App\Controller;
use Domain\User\Actions\Fortify\CreateNewUser;
use Domain\User\Data\UserCreateData;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\StatefulGuard;
use Laravel\Fortify\Contracts\RegisterResponse;

class RegisteredUserController extends Controller
{
    /**
     * The guard implementation.
     *
     * @var \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected $guard;

    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }

    public function store(UserCreateData $userCreateData, CreateNewUser $createNewUser): RegisterResponse
    {
        event(new Registered($user = $createNewUser->create($userCreateData)));

        $this->guard->login($user);

        return app(RegisterResponse::class);
    }
}
