<?php
spl_autoload_register(function ($className) {
    require_once $className.'.php';
});

require_once 'config.php';
require_once 'tools.php';
