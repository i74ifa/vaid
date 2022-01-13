<?php

use Symfony\Component\Process\Process;

if (! function_exists('should_be_sudo')) {
    function should_be_sudo()
    {
        if (!isset($_SERVER['SUDO_USER'])){
            throw new Exception('This command must be run with sudo.');
        }
    }
}

if (! function_exists('dd')) {
    function dd($data)
    {
        print_r($data);
        exit;
    }
}