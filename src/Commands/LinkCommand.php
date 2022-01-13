<?php

namespace I74ifa\Vaid\Commands;

use I74ifa\Vaid\Helpers\Apache;
use I74ifa\Vaid\Helpers\Conf;
use I74ifa\Vaid\Helpers\DirConfig;
use I74ifa\Vaid\Helpers\DistroType;
use I74ifa\Vaid\Helpers\FileConfig;
use I74ifa\Vaid\Helpers\CopySymlink;
use I74ifa\Vaid\Helpers\TypeProject;
use Symfony\Component\Process\Process;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;

class LinkCommand extends Command
{
    use DistroType {
        DistroType::__construct as private __dtConstruct;
    }
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'link';
    protected $cwd;
    protected $fullCwd;

    protected $dirConfig;

    protected $apacheConf;

    protected $apacheType;

    // TODO: Delete that
    protected $cwdConf;

    /**
     * append line Include to httpd
     * 
     * @var false $appendInclude
     */
    protected $appendInclude = false;

    public function __construct()
    {
        // check debian or fedora and arch
        $this->__dtConstruct();
        $this->setDirConfig();
        $this->setCwd();
        parent::__construct();
    }
    protected function configure(): void
    {
        $this->setDescription('link this directory');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        should_be_sudo();
        $dir = new TypeProject($this->fullCwd);
        if ($dir->getType() == 1 || $dir->getType() == 3) {
            $this->cwdConf = $this->fullCwd;
            $this->is_php();
        }else if($dir->getType() == 2) {
            $this->cwdConf = $this->fullCwd . '/public';
            $this->with_public();
        }
        // copy all SymLink
        new CopySymlink($this->dirConfig);
        $conf = Conf::instance($this->cwd['basename'])
            ->serverAdmin('example@app.com')
            ->documentRoot($this->cwdConf)
            ->options()
            ->allowOverride()
            ->requireGranted()
            ->getContent();
        new FileConfig($this->distroFile, $conf);

        // enable vaid.conf
        Apache::enableSite(basename($this->distroFile));
        Apache::restart($this->distroService);
        $output->write("<info>its generated 😇.</info>\n");
        return Command::SUCCESS;
    }


    protected function with_public()
    {
        $process = new Process(['ln', '-s', realpath($this->fullCwd . '/public'), $this->dirConfig . '/' . $this->cwd['basename']]);
        if (!CopySymlink::checkSymlink($this->dirConfig, $this->cwd['basename'])) {
            $process->run();
        }
    }

    protected function is_php()
    {
        $process = new Process(['ln', '-s', realpath($this->fullCwd), $this->dirConfig . '/' . $this->cwd['basename']]);

        if (!CopySymlink::checkSymlink($this->dirConfig, $this->cwd['basename'])) {
            $process->run();
        }
    }
    protected function setCwd()
    {
        $this->fullCwd = getcwd();
        $this->cwd = pathinfo(getcwd());
    }

    protected function setDirConfig(): void
    {
        $config = new DirConfig();

        $this->dirConfig = $config->dirConfig;
    }
}
