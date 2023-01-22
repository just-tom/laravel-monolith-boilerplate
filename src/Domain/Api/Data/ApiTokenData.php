<?php

namespace Domain\Api\Data;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Optional;

#[MapName(SnakeCaseMapper::class)]
class ApiTokenData extends Data
{
    public function __construct(
        public readonly int|Optional $id,
        public readonly string | Optional    $name,
        /** @var string[] $abilities */
        public readonly ?array        $abilities,
        /** @var string[] $permissions */
        public readonly ?array        $permissions,
        public readonly ?Carbon      $lastUsedAgo,
        public readonly string|null  $lastUsedAt,
        public readonly ?int          $tokenableId,
        public readonly ?string       $tokenableType,
    )
    {
    }

    public static function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'permissions' => 'array',
            'permissions.*' => 'string',
        ];
    }
}
