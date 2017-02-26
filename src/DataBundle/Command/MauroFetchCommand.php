<?php
namespace DataBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MauroFetchCommand extends Command
{
    protected function configure()
    {
      $this
          ->setName('mauro:fetch:weekly')
          ->setDescription('Fetches all the menus for this week')
      ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Mauro Menu weekly fetcher v.1.0');

        $siteFetcher = $this->getContainer()->get("mauro.data.site_fetcher");

        $io->text('Fetching...');
        $data = $siteFetcher->saveThisWeeksMenu(false);

        // @todo test if same week last-child

        //flush


    }
}
