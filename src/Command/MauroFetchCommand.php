<?php

namespace App\Command;

use App\Entity\Menu;
use App\Importer\SiteFetcher;
use Doctrine\ORM\EntityManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;

class MauroFetchCommand extends Command
{
    protected static $defaultName = 'mauro:fetch';

    private $entityManager;
    private $logger;
    private $siteFetcher;

    public function __construct(EntityManagerInterface $entityManager, LoggerInterface $logger, SiteFetcher $siteFetcher)
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
        $this->siteFetcher = $siteFetcher;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('mauro:fetch:weekly')
            ->setDescription('Fetches all the menus for this week')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Mauro Menu weekly fetcher v.2.0');

        try {
            // test if same week last-child
            $lastSunday = new \DateTime();
            $lastSunday->modify('last Sunday');

            $io->note('Mauro Menu for : ' . $lastSunday->format("Y-m-d"));

            $repo = $this->entityManager->getRepository(Menu::class);

            $entryForThisWeek = $repo->findOneByWeek($lastSunday);

            //flush
            if (is_null($entryForThisWeek)) {
                $io->text('Fetching...');
                $data = $this->siteFetcher->saveThisWeeksMenu(false);
                $this->entityManager->flush();
                $io->success('Menu saved!');
            } else {
                $io->comment('Menu already saved for this week!');
            }

        } catch (\Exception $e) {
            $io->error("ERROR : " .$e->getMessage());
            $this->logger->critical("[MAURO-FETCH-COMMAND] : " . $e->getMessage());
        }

        $io->text('Buh-bye!');

        return 0;
    }
}
