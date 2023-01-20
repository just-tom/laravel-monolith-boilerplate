<?php

namespace Domain\User\Data;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class AgentData extends Data
{
    public function __construct(
        public readonly string $browser,
        public readonly bool $isDesktop,
        public readonly string $platform,
    ) {}
}
