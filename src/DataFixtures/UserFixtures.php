<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Enum\EnumRoles;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\EnumType;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $user1 = new User();
        $user1->setEmail('abcd@gmail.com');
        $user1->setPassword('password');
        $user1->setRoles([EnumRoles::ROLE_ADMIN]);

        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail('zxcvbnm@gmail.com');
        $user2->setPassword('password');
        $user2->setRoles([EnumRoles::ROLE_USER]);

        $manager->persist($user2);

        $manager->flush();
    }
}
