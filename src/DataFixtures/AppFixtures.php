<?php

namespace App\DataFixtures;


use App\Entity\Genre;
use App\Entity\Movie;
use App\Entity\Person;

use App\DataFixtures\Data\GenreData;
use App\Entity\Casting;
use App\Entity\Season;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\FixturesBundle\Fixture;
use ProxyManager\Factory\RemoteObject\Adapter\XmlRpc;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {

        //on va d'abord créer les genres
        $genreModel = new GenreData();
        $genresList = $genreModel->getGenreData();
        foreach($genresList as $oneGenre) {
            $this->createGenre($oneGenre,$manager);
            $manager->flush();
        }

        //on va créer les personnages
        $personnModel = new PersonFixture();
        $personList= $personnModel->getPersonData();
        foreach ( $personList as $onePerson) {
            $this->createPerson($onePerson['firstname'],$onePerson['lastname'],$manager);
            $manager->flush();
        }

        //on va maintenant créer les films
        $movieModel = new MovieFixture();
        $moviesList = $movieModel->getMoviesData();

        foreach($moviesList as $oneMovie) {
            $movie = new Movie();
            $movie->setTitle($oneMovie['title']);
            $dateMovie = new DateTimeImmutable($oneMovie['release_date']);
            $movie->setReleaseDate($dateMovie);
            $movie->setDuration($oneMovie['duration']);
            $movie->setSummary($oneMovie['summary']);
            $movie->setSynopsis($oneMovie['synopsis']);
            $movie->setposter($oneMovie['poster']);
            $movie->setRating($oneMovie['rating']);
            $movie->setType($oneMovie['type']);

            foreach($oneMovie['genre'] as $oneGenre) {
                $newGenre = $this->getReference('GENRE-'.$oneGenre);
                $movie->addGenre($newGenre);
            }

            $castingMovie = $oneMovie['casting'];
            foreach ($castingMovie as $key => $info) {
                $newCasting = $this->createCasting($key, $info,$movie ,$manager);
                $movie->addCasting($newCasting);            
            }
            
            if($oneMovie['type'] == 'Série') {
                $seasonMovie = $oneMovie['season'];
                foreach ($seasonMovie as $key => $info) {
                    $newSeason = $this->createSeason($info,$movie ,$manager);
                    $movie->addSeason($newSeason);            
                } 
            }
 


            $manager->persist($movie);            
        }

        $manager->flush();
    }

    public function createGenre(string $name,ObjectManager $manager)
    {
        $genre = new Genre();
        $genre->setName($name);
        $manager->persist($genre);
        $this->addReference('GENRE-'.$name, $genre);      
        return $genre;
    }

    public function createPerson(string $firstname , string $lastname , ObjectManager $manager) 
    {
        $person = new Person();
        $person->setFirstname($firstname);
        $person->setLastname($lastname);
        $manager->persist($person);
        $this->addReference('PERSON-'.$firstname.$lastname,$person);
        return $person;
    }

    public function createCasting(int $key, $info ,Movie $movie ,ObjectManager $manager)
    {
        $personFixture = new PersonFixture();
        $personCastingDetail = $personFixture->getOnePersonData($info['actor']);
        $personCasting = $this->getReference('PERSON-'.$personCastingDetail['firstname'].$personCastingDetail['lastname']);
        $newCasting = new Casting();
        $newCasting->setRole($info['role']);
        $newCasting->setCreditOrder($key+1);
        $newCasting->setPerson($personCasting);
        $newCasting->setMovie($movie);
        $manager->persist($newCasting); 
        return $newCasting;

    }

    public function createSeason($info ,Movie $movie ,ObjectManager $manager)
    {
        $newSeason = new Season();
        $newSeason->setNumber($info['number']);
        $newSeason->setEpisodesNumber($info['episodes']);
        $newSeason->setMovie($movie);
        $manager->persist($newSeason);
        return $newSeason;

    }
}


