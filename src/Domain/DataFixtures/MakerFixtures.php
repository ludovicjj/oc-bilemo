<?php

namespace App\Domain\DataFixtures;

use App\Domain\Entity\Maker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class MakerFixtures extends fixture
{
    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $names = [
            'Alcatel',
            'Wiko',
            'BlackBerry',
            'Sony',
            'Nokia'
        ];

        foreach ($names as $name) {
            $maker = new Maker();
            $maker->createMaker($name);

            $manager->persist($maker);
            $this->addReference($name, $maker);
        }

        $manager->flush();
    }
}