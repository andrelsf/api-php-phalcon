<?php

$composer = require __DIR__ . '/vendor/autoload.php';

$modules = path_modules('/src');
foreach ($modules as &$module) {
    $namespace = explode("/", $module);
    $namespace = $namespace[count($namespace) - 2];
    $composer->setPsr4("App\\" . $namespace . "\\", $module);
}

return $composer;