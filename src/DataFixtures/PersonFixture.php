<?php

namespace App\DataFixtures;

class PersonFixture
{
    private $personData = [
        1   => [
            'firstname' =>  'Benedict',
            'lastname'  =>  'Cumberbatch'    
        ],
        2   =>  [
            'firstname' =>  'Chiwetel',
            'lastname'  =>  'Ejiofor'    
        ],
        3   =>  [
            'firstname' =>  'Rachel',
            'lastname'  =>  'McAdams'    
        ],
        4   =>  [
            'firstname' =>  'Benedict',
            'lastname'  =>  'Wong'    
        ],
        5   =>  [
            'firstname' =>  'Mads',
            'lastname'  =>  'Mikkelsen'    
        ],
        6   =>  [
            'firstname' =>  'Martin',
            'lastname'  =>  'Freeman'    
        ],
        7   =>  [
            'firstname' =>  'Amanda',
            'lastname'  =>  'Abbington'    
        ],
        8   =>  [
            'firstname' =>  'Simon',
            'lastname'  =>  'Pegg'    
        ],
        9  =>  [
            'firstname' =>  'Nick',
            'lastname'  =>  'Frost'    
        ],
        10  =>  [
            'firstname' =>  'Chris',
            'lastname'  =>  'Pine'    
        ],
        11  =>  [
            'firstname' =>  'Zachary',
            'lastname'  =>  'Quinto'    
        ],
        12  =>  [
            'firstname' =>  'Karl',
            'lastname'  =>  'Urban'    
        ],
        13  =>  [
            'firstname' =>  'Milo',
            'lastname'  =>  'Ventimiglia'    
        ],
        14 => [
            'firstname' =>  'Hayden',
            'lastname'  =>  'Panettiere'    
        ],
        15 => [
            'firstname' =>  'Adrian',
            'lastname'  =>  'Pasdar'    
        ],
        16 =>   [
            'firstname' =>  'Ian',
            'lastname'  =>  'McKellen'    
        ],
        17 =>         [
            'firstname' =>  'Richard',
            'lastname'  =>  'Armitage'    
        ],

    ];    

    /**
     * Get the value of personData
     */ 
    public function getPersonData()
    {
        return $this->personData;
    }

        /**
     * Get the value of personData
     */ 
    public function getOnePersonData($id)
    {
        return $this->personData[$id];
    }

}
