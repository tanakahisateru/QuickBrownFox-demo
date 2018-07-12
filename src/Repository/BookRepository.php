<?php
namespace Acme\App\Repository;

use Acme\App\Entity\Book;
use Acme\App\Repository\Hydration\DateTimeStrategy;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Zend\Hydrator\HydratorInterface;
use Zend\Hydrator\Reflection;

class BookRepository
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var HydratorInterface
     */
    private $hydrator;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;

        $this->hydrator = new Reflection();
        $this->hydrator->addStrategy('updated_at', new DateTimeStrategy());
    }

    /**
     * @return Book[]
     */
    public function findAll(): array
    {
        $rows = $this->connection->fetchAll(
            "SELECT * FROM books ORDER BY updated_at;"
        );

        $books = [];
        foreach ($rows as $row) {
            $book = $this->hydrator->hydrate($row, new Book());
            $books[] = $book;
        }

        return $books;
    }

    /**
     * @param int $id
     * @return Book|null
     */
    public function findOneById(int $id): ?Book
    {
        try {
            $row = $this->connection->fetchAssoc(
                "SELECT * FROM books WHERE id=?;",
                [$id]
            );
        } catch (DBALException $e) {
            return null;
        }

        if (!$row) {
            return null;
        }

        $book = $this->hydrator->hydrate($row, new Book());
        assert($book instanceof Book);
        return $book;
    }

    /**
     * @param string $title
     * @return Book|null
     */
    public function findOneByTitle(string $title): ?Book
    {
        try {
            $row = $this->connection->fetchAssoc(
                "SELECT * FROM books WHERE title=?;",
                [$title]
            );
        } catch (DBALException $e) {
            return null;
        }

        if (!$row) {
            return null;
        }

        $book = $this->hydrator->hydrate($row, new Book());
        assert($book instanceof Book);
        return $book;
    }
}
