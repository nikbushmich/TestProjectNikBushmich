<?php

declare(strict_types=1);

spl_autoload_register(static function ($class) {
    include str_replace("\\", "/", $class) . '.php';
});

