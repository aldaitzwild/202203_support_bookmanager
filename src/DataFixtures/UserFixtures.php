<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user
            ->setEmail('thomas.aldaitz@wildcodeschool.com')
            ->setRoles(['ROLE_ADMIN'])
        ;

        $hash = $this->passwordHasher->hashPassword($user, 'toto123');

        $user->setPassword($hash);

        $manager->persist($user);
        $manager->flush();
    }
}
