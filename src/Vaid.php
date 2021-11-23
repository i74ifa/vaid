<?php


namespace I74ifa\Vaid;

use I74ifa\Vaid\Bash\Color;
use I74ifa\Vaid\Bash\Style;

class Vaid
{

    protected string $dirProject;

    protected string $domain;

    protected string $basePath;

    protected array $pathInfo;

    protected $file;

    protected $ip;
    protected $fileName;

    public array $commands;
    public $serverAdmin  = 'i74ifa@gmail.com';

    public function __construct(public $command)
    {
        // all commands with desc
        $this->commands = [
            'link' => 'generate link by apache virtual host',
            'unlink' => 'disable website apache and remove file conf',
            'help' => 'show this !!😁'
        ];
        $this->dirProject = getcwd();
        $this->pathInfo();
        $this->typeProject();
    }


    /**
     * amazing start form here
     * 
     * if user not input command 
     * show all commands
     * 
     * if user enter command not exists
     * 
     * run command
     * 
     * @return string 
     */
    public function action(): string
    {
        // if user not input command 
        // show all commands
        if (! isset($this->command[1])) {
            return $this->getCommands();
        }
        // if user enter command is not exists
        $command = $this->command[1];
        if (!array_key_exists($command, $this->commands)) {
            return Color::red("Please Enter Command available\n") . $this->getCommands();
        }
        // run command
        return $this->$command();
    }
    
    
    public function link(): string
    {
        if (Apache::projectExist($this->domain)) {
            if (isset($this->command[2]) && $this->command[2] != '-n'){
                return 'its linked in '. $this->domain . ".test\n";            
            }
        }
        $this->ip = Apache::generateIp();
        $this->makeFile();
        Host::add($this->ip, $this->domain);
        $this->enableSite();

        return Color::green('link generated');

    }

    public function unlink(): string
    {
        Host::remove($this->domain);

        $this->disableSite();

        return Color::green("unlink success\n");
    }

    public function help(): string
    {
        return 'Only goto project directory and run ' . Color::cyan("vaid link\n\n") . "commands:\n" . $this->getCommands();
    }

    protected function makeFile(): void
    {
        $this->fileName = "$this->domain-$this->ip.conf";
        $file =  fopen(Apache::PATH_APACHE . $this->fileName, 'w') or die("please check if you root");

        fwrite($file, Apache::contentFile($this->ip, $this->basePath, $this->domain));

        fclose($file);
    }
    protected function enableSite(): void
    {
        Apache::enable($this->fileName);
    }


    protected function disableSite(): void
    {
        Apache::disable($this->fileName);
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

    public function getCommands()
    {
        $return = '';
        foreach ($this->commands as $key => $command) {
            $return .= Style::whiteSpace($key, $command);
        }

        return $return;
    }
}
