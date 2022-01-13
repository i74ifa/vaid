<?php

namespace I74ifa\Vaid\Helpers;

use Symfony\Component\Process\Process;

class Apache
{
    public static function enableSite($site)
    {
        $process = new Process(['sudo', 'a2ensite', $site]);
        $process->mustRun();
    }

    /**
     * type apache2 or httpd
     * 
     * @param apache2|httpd $type
     */
    public static function restart($type)
    {
        $process = new Process(['sudo', 'systemctl', 'restart', $type]);
        $process->mustRun();
    }

    public static function start($type)
    {
        $process = new Process(['sudo', 'systemctl', 'start', $type]);
        $process->mustRun();
    }

    public static function stop($type)
    {
        $process = new Process(['sudo', 'systemctl', 'stop', $type]);
        $process->mustRun();
    }

    public static function checkInstalled()
    {
        $find = shell_exec("dpkg -l apache2 | grep '^ii' | sed 's/\s\+/ /g' | cut -d' ' -f2");
        if (trim($find) == 'apache2') {
            return true;
        }

        return false;
    }

}
