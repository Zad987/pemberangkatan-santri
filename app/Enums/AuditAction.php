<?php

namespace App\Enums;

enum AuditAction: string
{
    case CREATE = 'CREATE';
    case CREATE_FAILED = 'CREATE_FAILED';
    case UPDATE = 'UPDATE';
    case UPDATE_FAILED = 'UPDATE_FAILED';
    case DELETE = 'DELETE';
    case DELETE_FAILED = 'DELETE_FAILED';
    case VIEW = 'VIEW';
    case VIEW_FAILED = 'VIEW_FAILED';
    case LOGIN = 'LOGIN';
    case LOGIN_FAILED = 'LOGIN_FAILED';
    case LOGIN_ERROR = 'LOGIN_ERROR';
    case LOGOUT = 'LOGOUT';
    case EXPORT = 'EXPORT';
    case IMPORT = 'IMPORT';

    public function description(): string
    {
        return match($this) {
            self::CREATE => 'Membuat data baru',
            self::CREATE_FAILED => 'Gagal membuat data',
            self::UPDATE => 'Memperbarui data',
            self::UPDATE_FAILED => 'Gagal memperbarui data',
            self::DELETE => 'Menghapus data',
            self::DELETE_FAILED => 'Gagal menghapus data',
            self::VIEW => 'Melihat data',
            self::VIEW_FAILED => 'Gagal melihat data',
            self::LOGIN => 'Masuk sistem',
            self::LOGIN_FAILED => 'Login gagal',
            self::LOGIN_ERROR => 'Error saat login',
            self::LOGOUT => 'Keluar sistem',
            self::EXPORT => 'Mengekspor data',
            self::IMPORT => 'Mengimpor data',
        };
    }

    public static function getAllActions(): array
    {
        return [
            self::CREATE->value => self::CREATE->description(),
            self::CREATE_FAILED->value => self::CREATE_FAILED->description(),
            self::UPDATE->value => self::UPDATE->description(),
            self::UPDATE_FAILED->value => self::UPDATE_FAILED->description(),
            self::DELETE->value => self::DELETE->description(),
            self::DELETE_FAILED->value => self::DELETE_FAILED->description(),
            self::VIEW->value => self::VIEW->description(),
            self::VIEW_FAILED->value => self::VIEW_FAILED->description(),
            self::LOGIN->value => self::LOGIN->description(),
            self::LOGIN_FAILED->value => self::LOGIN_FAILED->description(),
            self::LOGIN_ERROR->value => self::LOGIN_ERROR->description(),
            self::LOGOUT->value => self::LOGOUT->description(),
            self::EXPORT->value => self::EXPORT->description(),
            self::IMPORT->value => self::IMPORT->description(),
        ];
    }
}
