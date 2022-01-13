<?php

use Symfony\Component\Process\Process;

function should_be_sudo()
{
    if (!isset($_SERVER['SUDO_USER'])){
        throw new Exception('This command must be run with sudo.');
    }
}


function dd($data)
{
    print_r($data);
    exit;
}