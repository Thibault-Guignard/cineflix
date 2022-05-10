<?php

namespace App\DataFixtures;

use DateTimeImmutable;

class MovieFixture
{
    private $moviesData =    [
        1=>[
            'type' => 'Film',
            'title' => 'Doctor Strange',
            'release_date' => '2016-10-26',
            'duration' => 115,
            'summary' => 'Les début de Stephen Strange dans le MCU',
            'synopsis' => "Doctor Strange suit l'histoire du Docteur Stephen Strange, talentueux neurochirurgien qui, après un tragique accident de voiture, doit mettre son égo de côté et apprendre les secrets d'un monde caché de mysticisme et de dimensions alternatives. Basé à New York, dans le quartier de Greenwich Village, Doctor Strange doit jouer les intermédiaires entre le monde réel et ce qui se trouve au-delà, en utlisant un vaste éventail d'aptitudes métaphysiques et d'artefacts pour protéger le Marvel Cinematic Universe.",
            'poster' => 'https://m.media-amazon.com/images/M/MV5BNjgwNzAzNjk1Nl5BMl5BanBnXkFtZTgwMzQ2NjI1OTE@._V1_SX300.jpg',
            'rating' => 3.9,
            'casting' => [            
                    [   'actor' => 1, 
                        'role'  => 'Dr Stephen Strange'],
                    [   'actor' => 2, 
                        'role'   => 'Mordo'],
                    [   'actor' => 3, 
                        'role'   => 'Christine Palmer' ],
                    [   'actor' => 4, 
                        'role'   => 'Wong'],
                    [   'actor' => 5, 
                        'role'   => 'Kaecilius'],            
            ],
            'genre' => ['Fantastique', 'Aventure'],
        ],
        2=>[
            'type' => 'Série',
            'title' => 'Sherlock',
            'release_date' => '2010-01-01',
            'duration' => 90,
            'summary' => 'Les aventures de Sherlock Holmes et de son acolyte de toujours, le docteur Watson, sont transposées au XXIème siècle...',
            'synopsis' => "Détective surdoué, et hyperactif, Sherlock manie la science de la déduction, le flegme et l’humour avec sa dextérité légendaire… mais avec les outils d’aujourd’hui : téléphone ...",
            'poster' => 'https://fr.web.img5.acsta.net/pictures/18/11/05/18/04/4981046.jpg',
            'rating' => 4.5,
            'casting' => [            
                    [   'actor' => 1, 
                        'role'  => 'Sherlock Holmes'],
                    [   'actor' => 6, 
                        'role'   => 'Dr John Watson'],
                    [   'actor' => 7, 
                        'role'   => 'Mary Morstan' ],           
            ],
            'genre' => ['Aventure', 'Drame' , 'Policier'],
            'season' => [
                [   'number'    =>  1, 
                    'episodes'  =>  3],
                [   'number'    =>  2, 
                    'episodes'  =>  3],
                [   'number'    =>  3, 
                    'episodes'  =>  3],
                [   'number'    =>  4, 
                    'episodes'  =>  3],

            ],
        ],
        3=> [
            'type' => 'Film',
            'title' => 'Shaun of The Dead',
            'release_date' => '2004-12-21',
            'duration' => 99,
            'summary' => 'À presque 30 ans, Shaun ne fait pas grand-chose de sa vie',
            'synopsis' => "À presque 30 ans, Shaun ne fait pas grand-chose de sa vie. Entre l'appart qu'il partage avec ses potes et le temps qu'il passe avec eux au pub, Liz, sa petite amie, n'a pas beaucoup de place. Elle qui voudrait que Shaun s'engage, ne supporte plus de le voir traîner. Excédée par ses vaines promesses et son incapacité à se consacrer un peu à leur couple, Liz décide de rompre. Shaun est décidé à tout réparer, et tant pis si les zombies déferlent sur Londres, tant pis si la ville devient un véritable enfer. Retranché dans son pub préféré, le temps est venu pour lui de montrer enfin de quoi il est capable...",
            'poster' => 'https://m.media-amazon.com/images/M/MV5BMTg5Mjk2NDMtZTk0Ny00YTQ0LWIzYWEtMWI5MGQ0Mjg1OTNkXkEyXkFqcGdeQXVyNzkwMjQ5NzM@._V1_SX300.jpg',
            'rating' => 3.9,
            'casting' => [            
                    [   'actor' => 8, 
                        'role'  => 'Shaun'],
                    [   'actor' => 9, 
                        'role'   => 'Ed'],         
                ],
            'genre' => ['Comédie', 'Epouvante-horreur'],
        ],
        4=>[
            'type' => 'Film',
            'title' => 'Star Trek Into Darkness',
            'release_date' => '2013-06-12',
            'duration' => 130,
            'summary' => "Alors qu’il rentre à sa base, l’équipage de l’Enterprise doit faire face à des forces terroristes implacables au sein même de son organisation.",
            'synopsis' => "Alors qu’il rentre à sa base, l’équipage de l’Enterprise doit faire face à des forces terroristes implacables au sein même de son organisation. L’ennemi a fait exploser la flotte et tout ce qu’elle représentait, plongeant notre monde dans le chaos…
            Dans un monde en guerre, le Capitaine Kirk, animé par la vengeance, se lance dans une véritable chasse à l’homme, pour neutraliser celui qui représente à lui seul une arme de destruction massive.
            Nos héros entrent dans un jeu d’échecs mortel. L’amour sera menacé, des amitiés seront brisées et des sacrifices devront être faits dans la seule famille qu’il reste à Kirk : son équipe.",
            'poster' => 'https://m.media-amazon.com/images/M/MV5BMTk2NzczOTgxNF5BMl5BanBnXkFtZTcwODQ5ODczOQ@@._V1_SX300.jpg',
            'rating' => 3.7,
            'casting' => [            
                    [   'actor' => 1, 
                        'role'  => 'John Harrison'],
                    [   'actor' => 8, 
                        'role'   => 'Montgomery Scotty Scott'],
                    [   'actor' => 10, 
                        'role'   => 'James T Kirk' ],
                    [   'actor' => 11, 
                        'role'   => 'Spock'],
                    [   'actor' => 12, 
                        'role'   => 'Dr Leonard Bone Mc Coy'],            
            ],
            'genre' => ['Science-fiction', 'Action' , 'Aventure'],
        ],

        5   =>  [
            'type' => 'Film',
            'title' => 'Le Hobbit : Un voyage inatendu',
            'release_date' => '2012-12-12',
            'duration' => 169,
            'summary' => "Dans UN VOYAGE INATTENDU, Bilbon Sacquet cherche à reprendre le Royaume perdu des Nains d'Erebor, conquis par le redoutable dragon Smaug. Alors qu'il croise par hasard la route du magicien Gandalf le Gris, Bilbon rejoint une bande de 13 nains dont le chef n'est autre que le légendaire guerrier Thorin Écu-de-Chêne.",
            'synopsis' => "Dans UN VOYAGE INATTENDU, Bilbon Sacquet cherche à reprendre le Royaume perdu des Nains d'Erebor, conquis par le redoutable dragon Smaug. Alors qu'il croise par hasard la route du magicien Gandalf le Gris, Bilbon rejoint une bande de 13 nains dont le chef n'est autre que le légendaire guerrier Thorin Écu-de-Chêne. Leur périple les conduit au cœur du Pays Sauvage, où ils devront affronter des Gobelins, des Orques, des Ouargues meurtriers, des Araignées géantes, des Métamorphes et des Sorciers…
            Bien qu'ils se destinent à mettre le cap sur l'Est et les terres désertiques du Mont Solitaire, ils doivent d'abord échapper aux tunnels des Gobelins, où Bilbon rencontre la créature qui changera à jamais le cours de sa vie : Gollum.
            C'est là qu'avec Gollum, sur les rives d'un lac souterrain, le modeste Bilbon Sacquet non seulement se surprend à faire preuve d'un courage et d'une intelligence inattendus, mais parvient à mettre la main sur le 'précieux' anneau de Gollum qui recèle des pouvoirs cachés… Ce simple anneau d'or est lié au sort de la Terre du Milieu, sans que Bilbon s'en doute encore…",
            'poster' => 'https://fr.web.img5.acsta.net/c_310_420/medias/nmedia/18/93/43/35/20273834.jpg',
            'rating' => 4.2,
            'casting' => [            
                    [   'actor' => 16, 
                        'role'  => 'Gandalf le gris'],
                    [   'actor' => 6, 
                        'role'   => 'Bilbo Baggins'],
                    [   'actor' => 17, 
                        'role'   => 'Thorin Ecu de chene' ],          
            ],
            'genre' => ['Fantastique', 'Aventure'],
        ],

        6   => [
            'type' => 'Série',
            'title' => 'Heroes',
            'release_date' => '2006-09-25',
            'duration' => 42,
            'summary' => "Partout dans le monde, un certain nombre d'individus en apparence ordinaires se révèlent dotés de capacités hors du commun : la régénération cellulaire, la téléportation, la télépathie... Ils ne savent pas ce qui leur arrive, ni les répercussions que tout cela pourrait avoir. Ils ignorent encore qu'ils font partie d'une évolution qui va changer le monde à jamais !",
            'synopsis' => "Partout dans le monde, un certain nombre d'individus en apparence ordinaires se révèlent dotés de capacités hors du commun : la régénération cellulaire, la téléportation, la télépathie... Ils ne savent pas ce qui leur arrive, ni les répercussions que tout cela pourrait avoir. Ils ignorent encore qu'ils font partie d'une évolution qui va changer le monde à jamais !",
            'poster' => 'https://fr.web.img5.acsta.net/r_1920_1080/pictures/21/03/08/05/25/5902285.png',
            'rating' => 3.8,
            'casting' => [            
                    [   'actor' => 13, 
                        'role'  => 'Peter Petrelli'],
                    [   'actor' => 14, 
                        'role'   => 'Claire Bennet'],
                    [   'actor' => 15, 
                        'role'   => 'Nathan Petrelli' ],
                    [   'actor' => 11, 
                        'role'   => 'Gabriel "Sylar" Gray'],        
            ],
            'genre' => ['Drame', 'Fantastique','Science-fiction'],
            'season' => [
                [   'number'    =>  1, 
                    'episodes'  =>  23],
                [   'number'    =>  2, 
                    'episodes'  =>  11],
                [   'number'    =>  3, 
                    'episodes'  =>  25],
                [   'number'    =>  4, 
                    'episodes'  =>  19],
            
            ]
        ],

    ];

    /**
     * Get the value of moviesData
     */ 
    public function getMoviesData()
    {
        return $this->moviesData;
    }
}
/*
'type' => '',
'title' => '',
'release_date' => '',
'duration' => ,
'summary' => '',
'synopsis' => "",
'poster' => '',
'rating' => ,
'casting' => [            
        [   'actor' => 1, 
            'role'  => ''],
        [   'actor' => 2, 
            'role'   => ''],
        [   'actor' => 3, 
            'role'   => '' ],
        [   'actor' => 4, 
            'role'   => ''],
        [   'actor' => 5, 
            'role'   => ''],            
],
'genre' => ['', ''],
'season' => [
    [   'number'    =>  1, 
        'episodes'  =>  3],
    [   'number'    =>  2, 
        'episodes'  =>  3],
    [   'number'    =>  3, 
        'episodes'  =>  3],
    [   'number'    =>  4, 
        'episodes'  =>  3],

]
*/