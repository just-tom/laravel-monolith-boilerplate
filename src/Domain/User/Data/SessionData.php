<?php

namespace Domain\User\Data;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class SessionData extends Data
{
    public function __construct(
        public readonly string $ipAddress,
        public readonly bool $isCurrentDevice,
        public readonly string $lastActive,
        public readonly AgentData $agent,
    ) {}
}
