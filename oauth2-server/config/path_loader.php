<?php

if (!function_exists('path_modules')) 
{
    function path_modules ($suffix = '')
    {
        $paths = glob(__DIR__ . '/../src/Modules/*', GLOB_ONLYDIR);

        if ($suffix === "") {
            return $paths;
        }

        foreach ($paths as &$path) {
            $path = $path . $suffix;
        }

        return $paths;
    }
}