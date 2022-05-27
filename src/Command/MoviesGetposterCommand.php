<?php

namespace App\Command;

use App\Service\OMBDAPI;
use App\Service\OmdbApi;
use App\Repository\MovieRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MoviesGetposterCommand extends Command
{
    protected static $defaultName = 'app:movies:getposter';
    protected static $defaultDescription = 'Add a short description for your command';

    private $doctrine;
    private $movieRepository;
    private $omdbApi;

    public function __construct(
        MovieRepository $movieRepository,
        ManagerRegistry $doctrine,
        OmdbApi $omdbApi
    ) {
        $this->doctrine = $doctrine;
        $this->movieRepository = $movieRepository;
        $this->omdbApi  = $omdbApi;

        //on doit appeller le constructeur du parent depuis notre propre constructeur
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('title', InputArgument::OPTIONAL, 'Movie title to get');
            //->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
       
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $movieTitle = $input->getArgument('title');

        $io->info('Updating ... Posters');
        // $arg1 = $input->getArgument('arg1');

        if ($movieTitle !== null) {

            $movie = $this->movieRepository->findOneByTitle($movieTitle);

            // Film non trouvé ?
            if ($movie === null) {
                $io->error('Film non trouvé');

                return COMMAND::INVALID;
            }

            // On ajoute le film au tableau parcouru ci-dessous
            $movies = [$movie];

        } else {
            // Récupérer tous les films (via MovieRepository + findAll())
            $movies = $this->movieRepository->findAll();
        }

        // Pour chaque film
        foreach ($io->progressIterate($movies) as $movie) {
            //on veut acceder a l'API pour recuperer les infos de ce film
  
            $poster = $this->omdbApi->fetchPoster($movie->getTitle());

            if ($poster !== null ) {
                $movie->setPoster($poster);
            } else {
                $movie->setPoster('https://picsum.photos/id/'. random_int(1, 100).'/450/300');
            }
                       
        }

        // On flushe (on update les films en base)
        //Pas de persist les objets sont deja persiste en base
        $this->doctrine->getManager()->flush();

        $io->success('Movies poster updated.');

        return Command::SUCCESS;
    }
}
