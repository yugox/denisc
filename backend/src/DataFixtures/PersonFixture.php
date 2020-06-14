<?php

namespace App\DataFixtures;

use App\Entity\Person\Person;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PersonFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 0; $i < 10; $i++) {
            $person = new Person();
            $person->setFirstname('Max' .$i)
                ->setLastname('Mustermann' . $i)
                ->setAge(5 * $i);
            $manager->persist($person);
        }

        $manager->flush();
    }
}
