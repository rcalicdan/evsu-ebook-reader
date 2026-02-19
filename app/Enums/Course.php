<?php

namespace App\Enums;

enum Course: string
{
    case BSChE  = 'BSChE';
    case BSCE   = 'BSCE';
    case BSEE   = 'BSEE';
    case BSECE  = 'BSECE';
    case BSGE   = 'BSGE';
    case BSIE   = 'BSIE';
    case BSIT   = 'BSIT';
    case BSME   = 'BSME';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match ($this) {
            self::BSChE  => 'BS Chemical Engineering (BSChE)',
            self::BSCE   => 'BS Civil Engineering (BSCE)',
            self::BSEE   => 'BS Electrical Engineering (BSEE)',
            self::BSECE  => 'BS Electronics & Communications Engineering (BSECE)',
            self::BSGE   => 'BS Geodetic Engineering (BSGE)',
            self::BSIE   => 'BS Industrial Engineering (BSIE)',
            self::BSIT   => 'BS Information Technology (BSIT)',
            self::BSME   => 'BS Mechanical Engineering (BSME)',
        };
    }
}
