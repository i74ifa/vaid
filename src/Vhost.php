<?php


namespace I74ifa\Vaid;

class Vhost
{

    protected string $dirProject;

    protected string $domain;

    protected string $basePath;

    protected array $pathInfo;

    protected $file;

    protected $ip;
    protected $fileName;

    public $commands = [];
    public $serverAdmin  = 'i74ifa@gmail.com';

    public function __construct(public $command)
    {
        $this->commands = [
            'link', 'unlink'
        ];
        $this->dirProject = getcwd();
        $this->pathInfo();
        $this->typeProject();
    }

    public function action()
    {
        $command = $this->command;
        if (in_array($this->command, $this->commands)) {
            return $this->$command();
        }
    }
    
    
    public function link()
    {
        if (Apache::projectExist($this->domain)) {
            return 'its linked in '. $this->domain . ".test\n";            
        }
        $this->ip = Apache::generateIp();
        $this->makeFile();
        Host::add($this->ip, $this->domain);
        return $this->enableSite();

    }

    public function unlink()
    {
        Host::remove($this->domain);


        return $this->disableSite();
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
        Apache::enable($this->fileName);
        return 'link generated';
    }


    protected function disableSite()
    {
        Apache::disable($this->fileName);
        return 'unlink success';
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
