<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case LUNAS = 'lunas';
    case BELUM = 'belum';

    public function label(): string
    {
        return match($this) {
            self::LUNAS => 'Lunas',
            self::BELUM => 'Belum Dibayar',
        };
    }

    public static function getAllStatuses(): array
    {
        return [
            self::LUNAS->value => self::LUNAS->label(),
            self::BELUM->value => self::BELUM->label(),
        ];
    }
}