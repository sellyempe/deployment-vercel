<?php

if (! function_exists('get_setting')) {
    function get_setting($key, $default = null)
    {
        static $settings;

        if (is_null($settings)) {
            try {
                $settings = \App\Models\CompanySetting::pluck('value', 'key')->toArray();
            } catch (\Exception $e) {
                $settings = [];
            }
        }

        return $settings[$key] ?? $default;
    }
}

if (! function_exists('format_image_url')) {
    function format_image_url($image)
    {
        if (! $image) {
            return null;
        }
        if (str_starts_with($image, 'http')) {
            return $image;
        }

        $path = ltrim($image, '/');
        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, 8);
        }

        return '/storage/'.$path;
    }
}
