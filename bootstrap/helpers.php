<?php

if (!function_exists('get_prefix')) {
    function get_prefix()
    {
        if (isset($_SERVER['REQUEST_URI'])) {
            $locale = substr($_SERVER['REQUEST_URI'], 0, 3);

            if ($locale == '/en') {
                app()->setLocale('en');
                $prefix = $locale;
            } else {
                app()->setLocale('de');
                $prefix = '';
            }

            return $prefix;
        }
        return;
    }
}
