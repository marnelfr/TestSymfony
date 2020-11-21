<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture {


    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for($i = 0; $i<10; $i++) {
            $user = (new User())
                ->setEmail("user{$i}@nel.fr")
                ->setPassword('0000');

            $manager->persist($user);
        }
        $manager->flush();
    }



}
