<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $author = $this->getReference('author_1');

        $book = new Book();
        $book
            ->setTitle('Toto à la plage')
            ->setDescription("C'est toto qui va à la plage !")
            ->setNbOfPages(12)
            ->setAuthor($author)
        ;

        $manager->persist($book);

        $manager->flush();
    }
}
