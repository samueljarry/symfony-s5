<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use App\Entity\Category;
use App\Entity\Movie;
use App\Entity\Nationality;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Xylis\FakerCinema\Provider\Person;
use Xylis\FakerCinema\Provider\Movie as FakerMovie;

class AppFixtures extends Fixture
{
    private array $rewards = ['Oscars', 'Grammies', 'Golden Globe', 'César', 'Aucun'];
    /** @var Nationality[] $nationalities */
    private array $nationalities = [];
    /** @var Category[] $categories */
    private array $categories = [];
    /** @var Actor[] $actors */
    private array $actors = [];
    public function __construct(protected UserPasswordHasherInterface $passwordHasherInterface)
    {
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create();
        $this->loadNationalities($manager, $faker);
        $this->loadCategories($manager, $faker);
        $this->loadActorFixtures($manager, $faker);
        $this->loadMovies($manager, $faker);
        $this->loadUsers($manager, $faker);
    }

    private function loadNationalities(ObjectManager $manager, Faker\Generator $faker): void
    {
        $countries = [];
        for ($i = 0; $i < 20; $i++) {
            array_push($countries, $faker->unique()->country());
        }

        foreach ($countries as $country) {
            $nationality = new Nationality();
            $nationality->setName($country);

            array_push($this->nationalities, $nationality);
            $manager->persist($nationality);
        }
    }

    private function loadCategories(ObjectManager $manager, Faker\Generator $faker): void
    {
        $faker->addProvider(new FakerMovie($faker));

        $genres = $faker->movieGenres(20);
        $filteredGenres = array();

        // Remove duplicates as $faker->unique() don't work with CinemaProvider
        foreach ($genres as $genre) {
            if (!in_array($genre, $filteredGenres)) {
                $filteredGenres[] = $genre;
            }
        }

        foreach ($filteredGenres as $genre) {
            $category = new Category();
            $category->setName($genre);

            array_push($this->categories, $category);
            $manager->persist($category);
        }
    }
    private function loadActorFixtures(ObjectManager $manager, Faker\Generator $faker): void
    {
        $faker->addProvider(new Person($faker));
        $actors = $faker->actors($gender = null, $count = 70, $duplicates = false);

        foreach ($actors as $item) {
            $fullName = $item;
            $fullNameExploded = explode(' ', $fullName);

            $firstName = $fullNameExploded[0];
            $lastName = $fullNameExploded[1];

            $actor = new Actor();
            $actor->setFirstName($firstName);
            $actor->setLastName($lastName);
            $actor->setFullName($firstName.' '.$lastName);
            $actor->setRewards([$this->rewards[rand(0, 4)]]);
            $actor->setNationality($this->nationalities[0]);

            array_push($this->actors, $actor);
            $manager->persist($actor);
        }

        $manager->flush();
    }
    private function loadMovies(ObjectManager $manager, Faker\Generator $faker): void
    {
        $movies = $faker->movies(100);

        foreach ($movies as $item) {
            $movie = new Movie();
            shuffle($this->categories);

            $movie->setTitle($item);
            $movie->setReleaseDate($faker->dateTimeThisCentury()->format('Y-m-d H:i:s'));
            $movie->setDuration(rand(60, 180));
            $movie->setNote(rand(0, 10));
            $movie->setEntries(rand(1000, 4000000));
            $movie->setDirector($faker->director());
            $movie->setDescription($faker->overview());
            $movie->setCategory($this->categories[0]);

            shuffle($this->actors);
            $createdActorsSliced = array_slice($this->actors, 0, 4);

            foreach ($createdActorsSliced as $actor) {
                $movie->addActor($actor);
            }

            $manager->persist($movie);
        }
    }

    private function loadUsers(ObjectManager $manager, Faker\Generator $faker): void
    {
        $user = new User();
        $user->setEmail('user@mail.com');
        $user->setUsername('user');
        $user->setPassword($this->passwordHasherInterface->hashPassword($user, 'test'));
        $manager->persist($user);
        $manager->flush();
    }
}
