<?php
declare(strict_types=1);

namespace Domain\Global\Data;

use Domain\Global\Enums\NotificationType;
use Spatie\LaravelData\Data;

class NotificationData extends Data
{
    public function __construct(
        public NotificationType $type,
        public string           $body
    )
    {
    }
}
