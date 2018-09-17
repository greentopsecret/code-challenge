<?php

namespace App\DataFixtures;

use App\Entity\City;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CityFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $cities = [
            ['Berlin', '10115'],
            ['Porta Westfalica', '32457'],
            ['Lommatzsch', '01623'],
            ['Hamburg', '21521'],
            ['Bülzig', '06895'],
            ['Diesbar-Seußlitz', '01612'],
        ];

        foreach ($cities as list($name, $zip)) {
            $city = new City();
            $city->setName($name);
            $city->setZip($zip);
            $manager->persist($city);
        }

        $manager->flush();
    }
}