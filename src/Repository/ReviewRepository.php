<?php

namespace Acme\App\Repository;


use Acme\App\Entity\Book;
use Acme\App\Entity\Review;
use Acme\App\Repository\Hydration\DateTimeStrategy;
use Doctrine\DBAL\Connection;
use Zend\Hydrator\HydratorInterface;
use Zend\Hydrator\Reflection;

class ReviewRepository
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var BookRepository
     */
    protected $bookRepository;

    /**
     * @var HydratorInterface
     */
    private $hydrator;

    /**
     * @param Connection $connection
     * @param BookRepository $bookRepository
     */
    public function __construct(Connection $connection, BookRepository $bookRepository)
    {
        $this->connection = $connection;
        $this->bookRepository = $bookRepository;

        $this->hydrator = new Reflection();
        $this->hydrator->addStrategy('reviewed_at', new DateTimeStrategy());
    }

    /**
     * @param Book $book
     * @return Review[]
     */
    public function findAllByBook(Book $book, $linkBack = false): array
    {
        $rows = $this->connection->fetchAll(
            "SELECT * FROM reviews WHERE book_id=? ORDER BY reviewed_at;",
            [$book->id]
        );

        $reviews = [];
        foreach ($rows as $row) {
            $review = $this->hydrator->hydrate($row, new Review());
            assert($review instanceof Review);
            if ($linkBack) {
                $review->book = $book;
            } else {
                $review->book = $this->bookRepository->findOneById($review->book_id);
            }
            $reviews[] = $review;
        }

        return $reviews;
    }


}