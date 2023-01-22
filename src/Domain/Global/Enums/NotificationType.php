<?php
declare(strict_types=1);

namespace Domain\Global\Enums;

enum NotificationType: string
{
    case Success = 'success';
    case Error = 'error';
    case Warning = 'warning';
    case Info = 'info';
    case Default = 'default';
}
