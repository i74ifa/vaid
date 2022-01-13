<?php

namespace I74ifa\Vaid\Helpers;

use Symfony\Component\Process\Process;

class DirConfig
{

    public $dirConfig;

    public function __construct()
    {
        $this->setDirConfig();

        if (! $this->checkDir()){
            $this->createDir();
        }

        
    }

    protected function checkDir()
    {
        if (array_search('vaid', scandir($this->dirConfig))){
            if (is_dir($this->dirConfig . '/vaid')){
                $this->dirConfig .= '/vaid';
                return true;
            }
        }

        return false;
    }

    protected function createDir()
    {
        $path = $this->dirConfig . '/vaid';
        mkdir($path);
        $this->dirConfig .= '/vaid';
    }

    protected function setDirConfig()
    {
        if (isset($_SERVER['SUDO_USER'])) {
            $this->dirConfig = '/home/' . trim($_SERVER['SUDO_USER']) . '/.config';
        }else {
            $this->dirConfig = $_SERVER['HOME'];
        }
    }
}