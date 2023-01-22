<?php
declare(strict_types=1);

namespace App\Api\Controllers;

use App\Controller;
use Domain\Api\Data\ApiTokenData;
use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;
use Laravel\Sanctum\PersonalAccessToken;

class ApiTokenController extends Controller
{
    public function index(Request $request)
    {
        return Jetstream::inertia()->render($request, 'API/Index', [
            'tokens' => ApiTokenData::collection($request->user()->tokens->map(function ($token) {
                return $token->toArray() + [
                        'last_used_ago' => optional($token->last_used_at)->diffForHumans(),
                    ];
            })),
            'availablePermissions' => Jetstream::$permissions,
            'defaultPermissions' => Jetstream::$defaultPermissions,
        ]);
    }

    public function store(ApiTokenData $apiTokenData)
    {
        $token = request()->user()->createToken(
            $apiTokenData->name,
            Jetstream::validPermissions($apiTokenData->permissions)
        );

        return back()->with('flash', [
            'token' => explode('|', $token->plainTextToken, 2)[1],
        ]);
    }

    public function update(ApiTokenData $apiTokenData, Request $request, string $tokenId)
    {
        $token = $request->user()->tokens()->where('id', $tokenId)->firstOrFail();

        $token->forceFill([
            'abilities' => Jetstream::validPermissions($apiTokenData->permissions),
        ])->save();

        return back(303);
    }

    /**
     * Delete the given API token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $tokenId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $tokenId)
    {
        $request->user()->tokens()->where('id', $tokenId)->first()->delete();

        return back(303);
    }
}
