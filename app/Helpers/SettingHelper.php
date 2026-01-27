<?php

namespace App\Helpers;

use App\Models\Setting;

class SettingHelper
{
    /**
     * Get a setting value by key
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        try {
            $setting = Setting::where('key', $key)->first();
            return $setting?->value ?? $default;
        } catch (\Exception $e) {
            return $default;
        }
    }
}

if (!function_exists('setting')) {
    /**
     * Helper function to get a setting value
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function setting($key, $default = null)
    {
        return \App\Helpers\SettingHelper::get($key, $default);
    }
}
