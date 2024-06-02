<?php

class Autoload
{
    public function __construct()
    {
        spl_autoload_register([$this, 'load']);
    }

    public function load($className)
    {
        $className = str_replace("\\", DIRECTORY_SEPARATOR, $className);
        $file = __ROOT__ . DIRECTORY_SEPARATOR . $className . '.php';

        if (file_exists($file)) {
            require $file;
        } else {
            throw new Exception("Class file for {$className} not found at {$file}");
        }
    }
}