<?php

declare(strict_types=1);

if(function_exists('vd') === false) {
    function vd() {
        array_map(function($x) {
            var_dump($x);
        }, func_get_args());
        die;
    }
}

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Core\Kernel;

$config = require_once __DIR__ . '/../Config/app.php';

Kernel::start($config);