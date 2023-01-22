<?php
declare(strict_types=1);

namespace Domain\Global\Data;

use Closure;
use Domain\User\Data\UserData;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScriptType;

class SharedData extends Data
{
    public function __construct(
        #[TypeScriptType(UserData::class)]
        public ?Closure          $user = null,
        public ?NotificationData $notification = null
    )
    {
        $this->shareNotification();
    }

    protected function shareNotification(): void
    {
        if (session('notification')) {
            $this->notification = new NotificationData(
                ...session('notification')
            );
        }
    }
}
