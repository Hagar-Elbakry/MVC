<?php

spl_autoload_register(function($className) {
    $path = "../models";
    $extension = '.php';
    $fullPath = $path . $className . $extension;

    if(file_exists($fullPath)) {
        require $fullPath;
    }
});

require 'config.php';
require 'Database.php';
require 'Models.php';
require 'Controller.php';
require 'App.php';

