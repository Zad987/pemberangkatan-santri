<?php

namespace App\Enums;

enum UserRole: string
{
    case INDUK = 'induk';
    case DAERAH = 'daerah';
    case UMUM = 'umum';

    public function label(): string
    {
        return match($this) {
            self::INDUK => 'Administrator',
            self::DAERAH => 'Perwakilan Daerah',
            self::UMUM => 'Pengunjung',
        };
    }

    public static function getAllRoles(): array
    {
        return [
            self::INDUK->value => self::INDUK->label(),
            self::DAERAH->value => self::DAERAH->label(),
            self::UMUM->value => self::UMUM->label(),
        ];
    }
}