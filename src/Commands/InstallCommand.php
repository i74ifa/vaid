<?php

namespace I74ifa\Vaid\Commands;

use I74ifa\Vaid\Helpers\Apache;
use I74ifa\Vaid\Helpers\DistroType;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class InstallCommand extends Command
{
    use DistroType {
        DistroType::__construct as private __dtConstruct;
    }

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'install';


    public function __construct()
    {
        // check debian or fedora and arch
        $this->__dtConstruct();
        parent::__construct();
    }
    protected function configure(): void
    {
        $this->setDescription('install vaid dependencies');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->moveSymlink($output);
        $this->installApache($output);

        // move to /usr/local/bin

        return Command::SUCCESS;
    }

    protected function installApache(OutputInterface $output)
    {
        // install apache2 
        if (! Apache::checkInstalled()) {
            $output->write("<info>installing " . $this->distroService . "...</info>\n");
            $process = new Process(['sudo', 'apt', 'install', $this->distroService]);
            $process->run();
            $process = new Process(['sudo', 'systemctl', 'enable', $this->distroService]);
            $process->run();
            $process = new Process(['sudo', 'systemctl', 'start', $this->distroService]);
            $process->run();

        }
    }

    protected function moveSymlink(OutputInterface $output)
    {
        $dir = realpath($_SERVER['argv'][0]);
        $bins = scandir('/usr/local/bin/');
        if (! in_array('vaid', $bins)) {
            $output->write("<info>symlink to users bin to /usr/local/bin</info>\n");
            $dir = dirname(__DIR__) . '/vaid';
            shell_exec("sudo ln -snf $dir /usr/local/bin/");
        }
    }
}
