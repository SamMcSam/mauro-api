<?php
namespace DataBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MauroFetchCommand extends ContainerAwareCommand
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

        try {
          // test if same week last-child
          $lastSunday = new \DateTime();
          $lastSunday->modify('last Sunday');

          $io->note('Mauro Menu for : ' . $lastSunday->format("Y-m-d"));

          $em = $this->getContainer()->get('doctrine.orm.entity_manager');
          $repo = $em->getRepository("DataBundle:Menu");

          $entryForThisWeek = $repo->findOneByWeek($lastSunday);

          //flush
          if (is_null($entryForThisWeek)) {
            $siteFetcher = $this->getContainer()->get("mauro.data.site_fetcher");

            $io->text('Fetching...');
            $data = $siteFetcher->saveThisWeeksMenu(false);
            $em->flush();
            $io->success('Menu saved!');
          } else {
            $io->comment('Menu already saved for this week!');
          }

        } catch (\Exception $e) {
            $io->error("ERROR : " .$e->getMessage());
            $this->getContainer()->get('logger')->critical("[MAURO-FETCH-COMMAND] : " . $e->getMessage());
        }

        $io->text('Buh-bye!');
    }
}
