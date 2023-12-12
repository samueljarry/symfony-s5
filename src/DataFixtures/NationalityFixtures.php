<?php

namespace App\DataFixtures;

use App\Entity\Nationality;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class NationalityFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $nationalities = [
            "Française",
            "Espagnole",
            "Italienne",
            "Allemande",
            "Britannique",
            "Irlandaise",
            "Portugaise",
            "Belge",
            "Suédoise",
            "Norvégienne",
            "Danoise",
            "Grecque",
            "Russe",
            "Polonaise",
            "Ivoirienne",
            "Marocaine",
            "Algérienne",
            "Tunisienne",
            "Sénégalaise",
            "Américaine",
            "Canadienne",
            "Brésilienne",
            "Argentine",
            "Chilienne",
            "Mexicaine",
            "Japonaise",
            "Chinoise",
            "Indienne",
            "Australienne",
            "Néo-zélandaise"
        ];

        foreach (range(1, 27) as $i) {
            $nationality = new Nationality();
            $nationality->setName($nationalities[$i]);
            $manager->persist($nationality);
            $this->addReference('nationality_' . $i, $nationality);
        }

        $manager->flush();
    }
}
