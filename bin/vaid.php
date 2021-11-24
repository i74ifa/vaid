<?php

require __DIR__ . '/../vendor/autoload.php';

use I74ifa\Vaid\Bash\Color;
use I74ifa\Vaid\Vaid;


// if user is root
if (posix_getuid() != 0) {
    echo Color::red("run as sudo\n");
    exit;
}

$vhost = new Vaid($argv);
echo $vhost->action() . "\n";