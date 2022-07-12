<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
use App\Form\BookType;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use App\Service\OMDBConnector;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    #[Route('/', name: 'app_home')]
    public function index(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findAll();
        $borrowedBooks = $bookRepository->findBy(['isBorrowed' => true]);

        return $this->render('book/index.html.twig', [
            'books' => $books,
            'borrowedBooks' => $borrowedBooks
        ]);
    }

    #[Route('/book/add', name: 'app_book_add')]
    #[IsGranted('ROLE_ADMIN')]
    public function add(BookRepository $bookRepository, Request $request) {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $bookRepository->add($book, true);

            return $this->redirectToRoute('app_book');
        }

        return $this->renderForm('book/add.html.twig', ['form' => $form]);
    }

    #[Route('/book/{id}', name: 'app_book_details')]
    public function details(Book $book, OMDBConnector $omdbConnector, BookRepository $bookRepository) {

        $movie = $omdbConnector->getInfosMovie($book->getTitle());
        $borrowedBooks = $bookRepository->findBy(['isBorrowed' => true]);

        return $this->render('book/details.html.twig', [
            'book' => $book, 
            'movie' => $movie,
            'borrowedBooks' => $borrowedBooks
        ]);
    }

    #[Route('/book/author/{lastname}', name: 'app_book_author_list')]
    public function authorList(string $lastname, AuthorRepository $authorRepository, BookRepository $bookRepository) {

        $author = $authorRepository->findOneBy(['lastname' => $lastname]);

        $books = $bookRepository->findBy(['author' => $author]);

        return $this->render('book/index.html.twig', ['books' => $books]);
    }


    #[Route('/book/borrow/{id}', name: 'app_book_borrow')]
    public function borrowBook(Book $book, BookRepository $bookRepository) {
        $book->setIsBorrowed(true);

        $bookRepository->add($book, true);

        return new Response($book->getTitle());
    }


    
}
