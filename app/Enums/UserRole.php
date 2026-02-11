<?php

namespace App\Enums;

enum UserRole: string
{
    case STUDENT = 'student';
    case ADMIN = 'admin';
    case SUPERADMIN = 'superadmin';

    public function label(): string
    {
        return match ($this) {
            self::STUDENT => 'Student',
            self::ADMIN => 'Admin',
            self::SUPERADMIN => 'Super Admin',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::STUDENT => 'info',
            self::ADMIN => 'warning',
            self::SUPERADMIN => 'primary',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
