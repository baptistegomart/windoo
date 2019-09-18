<?php

namespace App\DataFixtures;

use App\Entity\Idea;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\DateTime;

class IdeaFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {    $faker = \Faker\Factory::create('fr_FR');

        for ($i=1; $i<=15; $i++){
            $idea = new Idea();

            $idea->setTitle($faker->catchPhrase)
                ->setText($faker->text($maxNbChars = 200))
                ->setDate($faker->dateTimeBetween('-6 months'))
                ->setRating($faker->biasedNumberBetween($min = 10, $max = 200, $function = 'sqrt'));
                // ->setAuthor($faker->name);

            $manager->persist($idea);
        }

              

        $manager->flush();
    }
}
