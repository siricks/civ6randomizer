<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('Siricks');
        $user->setPassword('$2y$13$.swN8t0O.zQo3jJ9VTYIxeX9ALXIB6CT/4tand1jJKUckNmp9BBke');
        $manager->persist($user);
        $manager->flush();
    }
}
