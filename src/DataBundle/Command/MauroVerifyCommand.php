<?php
namespace DataBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MauroVerifyCommand extends ContainerAwareCommand
{
    protected function configure()
    {
      $this
          ->setName('mauro:fetch:verify')
          ->setDescription('Fetches current menu and verify if not saved if dishes have changed')
      ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
    }
}
