<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findAll();
        return $this->render('book/index.html.twig', [
            'books' => $books,
        ]);
    }

    #[Route('/book/{id}', name: 'app_book_details')]
    public function details(Book $book) {
        return $this->render('book/details.html.twig', ['book' => $book]);
    }

    #[Route('/book/author/{lastname}', name: 'app_book_author_list')]
    public function authorList(string $lastname, AuthorRepository $authorRepository, BookRepository $bookRepository) {

        $author = $authorRepository->findOneBy(['lastname' => $lastname]);

        $books = $bookRepository->findBy(['author' => $author]);

        return $this->render('book/index.html.twig', ['books' => $books]);
    }
}
