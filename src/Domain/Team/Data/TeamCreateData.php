<?php

namespace Domain\Team\Data;

use Carbon\Carbon;
use Domain\User\Data\UserData;
use Domain\User\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Optional;

#[MapName(SnakeCaseMapper::class)]

class TeamCreateData extends Data
{
    public function __construct(
        public readonly string $name,
    ) {}

    public static function withValidator(Validator $validator): void
    {
        $validator->validateWithBag('createTeam');
    }

    public static function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
        ];
    }

    public static function fromRequest(Request $request): self
    {
        return self::from([
            ...$request->all(),
        ]);
    }
}
