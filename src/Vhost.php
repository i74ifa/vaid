<?php


namespace I74ifa\Vhost;

class Vhost
{

    protected string $dirProject;

    protected string $domain;

    protected string $basePath;

    protected array $pathInfo;

    protected $file;

    protected $ip;
    protected $fileName;
    public $serverAdmin  = 'i74ifa@gmail.com';

    public function __construct(public $command)
    {
        $this->dirProject = getcwd();
        $this->pathInfo();
        $this->typeProject();
    }

    public function action()
    {

        switch ($this->command) {
            case 'link':
                return $this->link();
        }
    }
    
    
    public function link()
    {
        if (Apache::projectExist($this->domain)) {
            echo 'its linked in '. $this->domain . ".test\n";
            exit;
        }else {
            $this->ip = Apache::generateIp();
            $this->makeFile();
            Host::add($this->ip, $this->domain);
            return $this->enableSite();

        }
    }

    protected function makeFile()
    {
        $this->fileName = "$this->domain-$this->ip.conf";
        $file =  fopen(Apache::PATH_APACHE . $this->fileName, 'w') or die("please check if you root");

        fwrite($file, Apache::contentFile($this->ip, $this->basePath, $this->domain));

        fclose($file);
    }
    protected function enableSite()
    {
        shell_exec("sudo a2ensite $this->fileName");
        shell_exec("sudo systemctrl restart apache2");

        return 'link generated';
    }

    protected function typeProject()
    {
        $scan = scandir($this->dirProject);

        if (array_search('public', $scan)) {
            $this->phpProjectWithPublic();
        } else {
            $this->phpProject();
        }
    }


    public function phpProject(): void
    {
        $this->basePath = $this->pathInfo['dirname'] . "/$this->domain/";
    }


    protected function pathInfo(): void
    {
        $path = pathinfo(trim($this->dirProject));
        $this->pathInfo = $path;
        $this->domain = $path['basename'];
    }
    /**
     * if path with public add the public to path
     */
    public function phpProjectWithPublic(): void
    {
        $this->basePath = $this->pathInfo['dirname'] . "/$this->domain/" . 'public/';
    }
}
