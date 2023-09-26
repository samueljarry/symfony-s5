<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        // Génere les données pour 10 acteurs avec un firstName et un lastName réaliste

        $firstNames = ['Jean', 'Pierre', 'Paul', 'Jacques', 'Marie', 'Julie', 'Julien', 'Jeanne', 'Pierre', 'Pauline'];
        $lastNames = ['Dupont', 'Durand', 'Duchemin', 'Duchesse', 'Duc', 'Ducroc', 'Ducrocq', 'Ducroq', 'Ducroque', 'Ducroquefort'];

        $nationalities = [];

        foreach (range(1, 10) as $i) {
            $actor = new Actor();
            $actor->setFirstName($firstNames[rand(0, 9)]);
            $actor->setLastName($lastNames[rand(0, 9)]);

            // Add Nationality
            $nationality = $this->getReference('nationality_' . rand(1, 5)); // Aussi, utilisez rand(1, 5), pas rand(1, 10)
            if (!in_array($nationality, $nationalities)) {
                $nationalities[] = $nationality; // Ajoutez à $nationalities, pas à $nationality
                $actor->addNationality($nationality);
            }

            $manager->persist($actor);
            $this->addReference('actor_' . $i, $actor); // "expose" l'objet à l'extérieur de la classe pour les liaisons avec Movie
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            NationalityFixtures::class
        ];
    }
}