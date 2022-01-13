<?php

namespace I74ifa\Vaid\Helpers;

/**
 * distro's like debian uses apache2 folder on /etc
 * but centos and redhat uses httpd
 * this class Recognize the type of distribution
 */
trait DistroType
{
    protected $distro = [];

    protected $distroFile;

    protected $distroSystem;
    
    protected $distroService;

    public function __construct()
    {
        $this->distro = [
            'debian' => 'debian_version',
            'centos' => 'centos-version',
            'redhat' => 'redhat-release',
            'fedora' => 'fedora-release',
        ];

        $this->setType();

    }
    public static function instance()
    {
        return new DistroType;
    }

    protected function findFile()
    {
        foreach ($this->distro as $key => $value) {
            if (file_exists('/etc/' . $value)) {
                return $key;
            }
        }

        return false;
    }

    public function setType()
    {
        if ($this->findFile() == 'debian') {
            $this->distroFile = '/etc/apache2/sites-available/vaid.conf';
            $this->distroSystem = 'debian';
            $this->distroService = 'apache2';
        } else {
            $this->distroFile =  '/etc/apache2/sites-available/vaid.conf';
            $this->distroSystem =  'debian';
            $this->distroService =  'httpd';
        }
    }
}
