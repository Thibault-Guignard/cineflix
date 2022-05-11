<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use App\Entity\Movie;
use App\Entity\Person;
use App\Entity\Season;

use DateTimeImmutable;

use App\Entity\Casting;
use App\DataFixtures\Data\GenreData;
use App\DataFixtures\Provider\OflixProvider;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // on instancie notre provider custom O'Flix
        $oflixProvider = new OflixProvider();
        // New Genre
        $genreModel = new GenreData();
        $genreData = $genreModel->getGenreData();
        $newGenre = [];
        for ($i = 0; $i < count($genreData); $i++) {
            $newGenre[$i] = new Genre();
            $newGenre[$i]->setName($genreData[$i]);

            $manager->persist($newGenre[$i]);
        }

        // Tableau pour nos persons
        $personsList = [];
        for ($i = 1; $i <= 100; $i++) {
            // Nouvelle Person
            $person = new Person();
            $person->setFirstname('Prénom #' . $i);
            $person->setLastname('Nom #' . $i);
            // On l'ajoute à la liste pour usage ultérieur
            $personsList[] = $person;
            // On persiste
            $manager->persist($person);
        } 

        // Les films
        for ($m = 1; $m <= 10; $m++) {             
            $movie = new Movie();

            $type = mt_rand(1,2) == 1 ? "Film" : "Série";
            $movie->setType($type);
            $movie->setSynopsis('Aenean blandit, tortor ac pellentesque luctus, arcu enim aliquam augue, ac malesuada est magna a elit. Integer venenatis lacus id elit lacinia tincidunt. Cras purus leo, faucibus dictum dictum id, convallis id neque. Pellentesque consequat lorem a lacus egestas tempor. Nunc rutrum, ipsum interdum ullamcorper porta, metus velit faucibus lorem, in ullamcorper ligula odio a ipsum. In scelerisque enim eget sem vehicula, eu aliquet neque accumsan. Curabitur sit amet eros ut dui congue tristique et nec erat. Pellentesque est lorem, eleifend ac feugiat sit amet, scelerisque ut odio. Cras vel lectus ante. Sed est elit, fermentum sit amet neque a, tincidunt gravida urna. Proin hendrerit ex at lorem cursus tincidunt. Nunc ultricies rhoncus iaculis.');
            //titre
            $movie->setTitle($type .' #'.$m);
            $movie->setSummary('Résumé de la '. $type .' #'.$m);
            $movie->setReleaseDate(new DateTimeImmutable('-' . mt_rand(1, 3000) . ' day'));
            // Entre 30 min et 263 minutes
            $movie->setDuration(mt_rand(30, 263));
            $movie->setPoster('https://picsum.photos/id/'.mt_rand(1, 100).'/450/300');
            $movie->setRating(mt_rand(10, 50)/10);

            // Add Seasons
            // On vérifie si l'entitéeMovie est une série ou pas
            if ($movie->getType() === 'Série') {
                // Si oui on crée une boucle for avec un numéro aléatoire dans la condition pour déterminer le nombre de saisons
                // mt_rand() ne sera exécuté qu'une fois en début de boucle
                for ($j = 1; $j <= mt_rand(3, 10); $j++) {
                    // On créé la nouvelle entitée Season
                    $season = new Season();
                    // On insert le numéro de la saison en cours $j
                    $season->setNumber($j);
                    // On insert un numéro d'épisode aléatoire
                    $season->setEpisodesNumber(mt_rand(5, 24));
                    // Puis on relie notre saison à notre série
                    $season->setMovie($movie);

                    // On persite
                    $manager->persist($season);
                }
            }

            // Add genre
            $tableauIndex = []; //tableau d'index 
            for ($j = 0; $j < mt_rand(1, 6); $j++) {
                //on choisit un nouvel index au hasard
                $newIndex = mt_rand(0, count($genreData) - 1);
                //s'il ne fait pas partie du tableau alors on peut ajouter le genre
                if (!in_array($newIndex, $tableauIndex)) {
                    $tableauIndex[] = $newIndex;
                    $movie->addGenre($newGenre[$newIndex]);
                }
            }

            //Add Casting

            // Avant de créer les castings
            // on mélange les valeurs du tableau $personsList
            // afin de piocher dedans les index 1, 2, 3, ... et ne pas avoir de doublon
            shuffle($personsList);

            // On ajoute de 3 à 10 castings par films au hasard pour chaque film
            for ($c = 1; $c <= mt_rand(3, 10); $c++) {
                $casting = new Casting();
                // Les propriétés role et creditOrder
                $casting->setRole('Rôle #' . $c);
                $casting->setCreditOrder($c);

                // Les 2 associations
                // Movie film courant de la boucle
                $casting->setMovie($movie);
                // Person
                // On pioche les index fixes 1, 2, 3, ...
                $randomPerson = $personsList[$c];
                $casting->setPerson($randomPerson);

                // On persiste
                $manager->persist($casting);
            }

            $manager->persist($movie);
        }

        $manager->flush();
    }
}
