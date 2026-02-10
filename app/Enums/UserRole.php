<?php

namespace App\Enums;

enum UserRole: string
{
    case SUPERADMIN = 'superadmin';
    case ADMIN = 'admin';
    case STUDENT = 'student';

    public function label(): string
    {
        return match($this) {
            self::SUPERADMIN => 'Super Administrator',
            self::ADMIN => 'Administrator',
            self::STUDENT => 'Student',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}