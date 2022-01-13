<?php

namespace I74ifa\Vaid\Helpers;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class CopySymlink
{
    public string $directory;

    public string $www = '/var/www/html';

    /**
     * 
     * @param string $directory to all SymLinks
     */

    public function __construct($directory)
    {
        $this->directory = $directory;

        $this->scan();
        $this->copy();
    }


    public function scan(): array
    {
        $scan = scandir($this->directory);
        unset($scan[0]); // unset .
        unset($scan[1]); // unset ..
        return $scan;
    }

    public function copy()
    {
        foreach ($this->scan() as $key => $value) {
            if (!self::checkSymlink($this->www, $value)) {
                $process = new Process(['sudo', 'cp', '-r', $this->directory . '/' . $value, $this->www]);
                $process->run();
            }
        }
    }


    public static function checkSymlink($dir, $field)
    {
        if (file_exists($dir . '/' . $field)) {
            return true;
        }

        return false;
    }
}
