<?php

namespace App\Enums;

enum DocumentVisibility: string
{
    case PUBLIC = 'public';
    case RESTRICTED = 'restricted';

    public function label(): string
    {
        return match($this) {
            self::PUBLIC => 'Public',
            self::RESTRICTED => 'Restricted',
        };
    }

    public function description(): string
    {
        return match($this) {
            self::PUBLIC => 'Visible to all users',
            self::RESTRICTED => 'Visible only to authorized users',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}