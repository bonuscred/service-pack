<?php

$mapping = require __DIR__.'/autoload_classmap.php';

spl_autoload_register(function ($class) use ($mapping) {
    if (isset($mapping[$class])) {
        require $mapping[$class];
    }
});