<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AuthorFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $author = new Author();
        $author
            ->setLastname('Aldaitz')
            ->setFirstname('Thomas')
            ->setAge(37)
            ;

        $manager->persist($author);

        $manager->flush();

        $this->addReference('author_1', $author);
    }
}
