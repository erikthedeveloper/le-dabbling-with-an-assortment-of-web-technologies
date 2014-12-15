<?php

define("APP_DIR", __DIR__);

/**
 * PSR-4 autoloader provided by PSR-4 documentation on GitHub
 * @link http://www.php-fig.org/psr/psr-4/
 */
spl_autoload_register(
    function ($class) {
        $prefix   = 'App\\';
        $base_dir = APP_DIR . "/App/";
        $len      = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            return;
        }
        $relative_class = substr($class, $len);
        $file           = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
        if (file_exists($file)) {
            require $file;
        }
    }
);

require_once APP_DIR . "/functions.php";
require_once APP_DIR . "/database.php";
require_once APP_DIR . "/session.php";