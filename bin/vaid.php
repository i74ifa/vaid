<?php

require __DIR__ . '/../vendor/autoload.php';

use I74ifa\Vaid\Bash\Color;
use I74ifa\Vaid\Vaid;



// check if installed

$bins = scandir('/usr/local/bin/');

if (!in_array('vaid', $bins)){
    echo Color::green("symlink to users bin to /usr/local/bin:\n");
    $dir = dirname(__DIR__) . '/vaid';
    shell_exec("sudo ln -snf $dir /usr/local/bin/");
}

// if user is root
if (posix_getuid() != 0) {
    echo Color::red("run as sudo\n");
    exit;
}

$vhost = new Vaid($argv);
echo $vhost->action() . "\n";