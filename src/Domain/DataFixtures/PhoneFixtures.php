<?php

namespace App\Domain\DataFixtures;

use App\Domain\Entity\Maker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Domain\Entity\Phone;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PhoneFixtures extends fixture implements DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $datas = [
            [
                'name' => '3C',
                'description' => "L’Alcatel 3C est le premier smartphone officialisé et détaillé de ce catalogue remanié. Il s’agit d’un smartphone low-cost, mais relativement complète pour son prix.",
                'price' => 93.32,
                'stock' => 256,
                'maker' => 'Alcatel'
            ],
            [
                'name' => 'Sunny 3',
                'description' => "Le Wiko Sunny 3 est le smartphone le moins cher chez Wiko pour l'année 2018. Un smartphone d'entrée de gamme qui n'évolue que très peu par rapport au Sunny 2 et Sunny 2 Plus sortis en 2017. La seule nouveauté concerne l'OS qui passe à Android Oreo (Go Edition). Et toujours les finitions mates ou brillante à travers 5 coloris disponibles : anthracite, or, argent, bleen et rouge.",
                'price' => 58.15,
                'stock' => 1548,
                'maker' => 'Wiko'
            ],
            [
                'name' => 'KEY2',
                'description' => "Le BlackBerry KEY2 a été présenté début juin 2018, soit un peu plus d’un an après son prédécesseur. C'est le cinquième smartphone développé par le constructeur chinois TCL pour le compte du groupe canadien BlackBerry après les DTEK50 et DTEK60, le KEYOne et le Motion. Il s’agit du successeur du KEYOne. Il en reprend donc l’ergonomie, tout en apportant quelques modifications au design.",
                'price' => 512.15,
                'stock' => 485,
                'maker' => 'BlackBerry'
            ],
            [
                'name' => 'Xperia XA1',
                'description' => "Le Sony Xperia XA1 a été dévoilé au Mobile World Congress 2017, où Sony a renouvelé sa gamme de « Xperia X », symbole de sa nouvelle stratégie exclusivement premium. Trois modèles y ont été officialisés : les Xperia XA1, XA1 Ultra et XZ.",
                'price' => 149.99,
                'stock' => 1478,
                'maker' => 'Sony'
            ],
            [
                'name' => '2.1',
                'description' => "Le Nokia 2.1 est un smartphone d'entrée de gamme. Successeur du Nokia 2, il est basé sur une plate-forme très modeste et un prix qui l’est encore plus. Le Nokia 2.1 est également le second mobile de la marque finlandaise à intégrer le programme Android Go de Google, après le Nokia 1 officialisé en février 2018.",
                'price' => 97.78,
                'stock' => 5488,
                'maker' => 'Nokia'
            ]
        ];

        foreach ($datas as $data) {
            /** @var Maker $maker */
            $maker = $this->getReference($data['maker']);
            $phone = new Phone();
            $phone->createPhone(
                $data['name'],
                $data['description'],
                $data['price'],
                $data['stock'],
                $maker
            );

            $manager->persist($phone);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            MakerFixtures::class
        );
    }
}