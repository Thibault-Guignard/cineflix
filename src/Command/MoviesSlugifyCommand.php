<?php

namespace App\Command;

use App\Service\MySlugger;
use App\Repository\MovieRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MoviesSlugifyCommand extends Command
{
    //nom de la commande (dans le "namespace" "app")
    protected static $defaultName = 'app:movies:slugify';
    //description de la commande (pour le -- help)
    protected static $defaultDescription = 'Set a slug for each movie in the database';

    private $doctrine;
    private $movieRepository;
    private $mySlugger;

    public function __construct(
        MovieRepository $movieRepository,
        MySlugger $mySlugger,
        ManagerRegistry $doctrine 
    ) {
        $this->doctrine = $doctrine;
        $this->movieRepository = $movieRepository;
        $this->mySlugger = $mySlugger;

        //on doit appeller le constructeur du parent depuis notre propre constructeur
        parent::__construct();
    }

    /**
     * configuration de la commande
     */
    protected function configure(): void
    {
        //$this
        //    ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
        //    ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        //;
    }

    /**
     * Execution de la commande
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->info('Updating ... files');

        /* if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        } */

        //on veut récuperer tous les films (via MovieRepository + findAll)
        $moviesList = $this->movieRepository->findAll();

        // Pour chaque film
            //On slugifie le film via MySlugger
        foreach ($moviesList as $movie) {
            $slug = $this->mySlugger->slugify($movie->getTitle());
            $movie->setSlug($slug);
        }

        // On flushe (on update les films en base)
        //Pas de persist les objets sont deja persiste en base
        $this->doctrine->getManager()->flush();

        $io->success('Movies slug updated.');

        return Command::SUCCESS;
    }
}
