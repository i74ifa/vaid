<?php
namespace I74ifa\Vaid\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Cursor;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UnlinkCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'unlink';

    protected function configure(): void
    {
        $this->setDescription('this directory to project link');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $cursor = new Cursor($output);
        for ($i=0; $i < 5; $i++) { 
            $cursor->moveDown();
            $output->write('##');
            $output->write('##');
            // $output->write("##");
        }
        
        
        
        
        
        
        
        $output->write("\n");
        return Command::SUCCESS;
    }
}
