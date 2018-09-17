<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ServiceFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $cities = [
            'Sonstige Umzugsleistungen',
            'Abtransport, Entsorgung und Entrümpelung',
            'Fensterreinigung',
            'Holzdielen schleifen',
            'Kellersanierung',
        ];

        foreach ($cities as $name) {
            $service = new Service();
            $service->setName($name);
            $manager->persist($service);
        }

        $manager->flush();
    }
}