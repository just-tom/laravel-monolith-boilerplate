<?php

use App\Api\Controllers\ApiTokenController;
use App\Team\Controllers\TeamController;
use App\Team\Controllers\TeamMemberController;
use App\User\Controllers\PasswordController;
use App\User\Controllers\ProfileInformationController;
use App\User\Controllers\RegisteredUserController;
use App\User\Controllers\UserProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use Laravel\Jetstream\Jetstream;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::group(['middleware' => config('fortify.middleware', ['web'])], function () {
    // Registration...
    if (Features::enabled(Features::registration())) {
        Route::post('/register', [RegisteredUserController::class, 'store'])
            ->middleware(['guest:'.config('fortify.guard')]);
    }

    // Passwords...
    if (Features::enabled(Features::updatePasswords())) {
        Route::put('/user/password', [PasswordController::class, 'update'])
            ->middleware([config('fortify.auth_middleware', 'auth').':'.config('fortify.guard')])
            ->name('user-password.update');
    }

    // Profile Information...
    if (Features::enabled(Features::updateProfileInformation())) {
        Route::put('/user/profile-information', [ProfileInformationController::class, 'update'])
            ->middleware([config('fortify.auth_middleware', 'auth').':'.config('fortify.guard')])
            ->name('user-profile-information.update');
    }
});

$authMiddleware = config('jetstream.guard')
    ? 'auth:'.config('jetstream.guard')
    : 'auth';

$authSessionMiddleware = config('jetstream.auth_session', false)
    ? config('jetstream.auth_session')
    : null;

Route::group(['middleware' => array_values(array_filter([$authMiddleware, $authSessionMiddleware]))], function () {
    // User & Profile...
    Route::get('/user/profile', [UserProfileController::class, 'show'])
        ->name('profile.show');

    if (Jetstream::hasApiFeatures()) {
        Route::get('/user/api-tokens', [ApiTokenController::class, 'index'])->name('api-tokens.index');
        Route::post('/user/api-tokens', [ApiTokenController::class, 'store'])->name('api-tokens.store');
        Route::put('/user/api-tokens/{token}', [ApiTokenController::class, 'update'])->name('api-tokens.update');
        Route::delete('/user/api-tokens/{token}', [ApiTokenController::class, 'destroy'])->name('api-tokens.destroy');
    }

    if (Jetstream::hasTeamFeatures()) {
        Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
        Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');
        Route::put('/teams/{team}', [TeamController::class, 'update'])->name('teams.update');
        Route::post('/teams/{team}/members', [TeamMemberController::class, 'store'])->name('team-members.store');
        Route::put('/teams/{team}/members/{user}', [TeamMemberController::class, 'update'])->name('team-members.update');

//        Route::get('/team-invitations/{invitation}', [TeamInvitationController::class, 'accept'])
//            ->middleware(['signed'])
//            ->name('team-invitations.accept');
//
//        Route::delete('/team-invitations/{invitation}', [TeamInvitationController::class, 'destroy'])
//            ->name('team-invitations.destroy');
    }
});
