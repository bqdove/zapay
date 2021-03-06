<?php

function classLoader($class)
{
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $path = str_replace('thinkweb' . DIRECTORY_SEPARATOR . 'zapay' . DIRECTORY_SEPARATOR, '', $path);

    $file = __DIR__ . '/src/' . $path . '.php';

    if (file_exists($file)) {

        require_once $file;
    }
}
spl_autoload_register('classLoader');
