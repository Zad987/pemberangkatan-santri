<?php

namespace App\Enums;

enum AuditAction: string
{
    case CREATE = 'CREATE';
    case UPDATE = 'UPDATE';
    case DELETE = 'DELETE';
    case VIEW = 'VIEW';
    case LOGIN = 'LOGIN';
    case LOGOUT = 'LOGOUT';
    case EXPORT = 'EXPORT';
    case IMPORT = 'IMPORT';

    public function description(): string
    {
        return match($this) {
            self::CREATE => 'Membuat data baru',
            self::UPDATE => 'Memperbarui data',
            self::DELETE => 'Menghapus data',
            self::VIEW => 'Melihat data',
            self::LOGIN => 'Masuk sistem',
            self::LOGOUT => 'Keluar sistem',
            self::EXPORT => 'Mengekspor data',
            self::IMPORT => 'Mengimpor data',
        };
    }

    public static function getAllActions(): array
    {
        return [
            self::CREATE->value => self::CREATE->description(),
            self::UPDATE->value => self::UPDATE->description(),
            self::DELETE->value => self::DELETE->description(),
            self::VIEW->value => self::VIEW->description(),
            self::LOGIN->value => self::LOGIN->description(),
            self::LOGOUT->value => self::LOGOUT->description(),
            self::EXPORT->value => self::EXPORT->description(),
            self::IMPORT->value => self::IMPORT->description(),
        ];
    }
}