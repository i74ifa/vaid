<?php

namespace I74ifa\Vaid\Helpers;

use Symfony\Component\Process\Process;

/**
 * generate file config vaid-configure.json
 */
class FileConfig
{
    /**
     * file apache conf 
     * 
     * @param string $conf
     */
    public $conf;
    protected $content;
    protected $field;

    protected $httpd;

    public function __construct($conf, $field)
    {
        if (is_dir($this->conf)) {
            $this->isHttpd();
        } else {
            $this->conf = $conf;
        }
        $this->field = $field;
        $this->checkFileExist();
        $this->getContentFile();
        $this->append();
        $this->saveChange();
    }


    protected function isHttpd(): void
    {
        $this->httpd = $this->conf . '/httpd.conf';
        $this->conf = $this->conf . '/vaid.conf';
    }

    public function checkFileExist(): void
    {
        if (! file_exists($this->conf)) {
            $this->createFile();
        }
    }

    public function createFile(): void
    {
        touch($this->conf);
    }

    public function getContentFile(): void
    {
        $this->content = file_get_contents($this->conf);
    }

    public function append(): void
    {
        $this->content .= $this->field;
    }


    protected function saveChange(): void
    {
        file_put_contents($this->conf, $this->content);
    }
}
