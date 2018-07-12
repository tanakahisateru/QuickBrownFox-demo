<?php
namespace Acme\App\Repository;

use Acme\App\TheApp;
use Doctrine\DBAL\Connection;
use Lapaz\QuickBrownFox\Database\FixtureSetupSession;
use Lapaz\QuickBrownFox\Database\SessionManager;
use PHPUnit\Framework\TestCase;

class BookRepositoryTest extends TestCase
{
    /**
     * @var FixtureSetupSession
     */
    protected $data;

    /**
     * @var BookRepository
     */
    private $repository;

    protected function setUp()
    {
        $this->repository = new BookRepository(TheApp::$container->get(Connection::class));

        $this->data = TheApp::$container->get(SessionManager::class)->newSession();
    }

    public function testFindOneByTitle()
    {
        $this->data->into('books')->load([
            ['title' => 'Perfect PHP'],
            ['title' => 'Perfect Java'],
        ]);

        $book = $this->repository->findOneByTitle('Perfect PHP');
        $this->assertEquals('Perfect PHP', $book->title);

        $book = $this->repository->findOneByTitle('Perfect Ruby');
        $this->assertNull($book);
    }

    public function testFindManyBooks()
    {
        $this->data->into('books')->with([
            'title' => function ($i) { return "Book - {$i}"; }
        ])->with('cheap')->generate(100);

        $books = $this->repository->findAll();
        $this->assertCount(100, $books);
    }

    public function testFindNoBooks()
    {
        $this->data->into('books')->load([]);

        $books = $this->repository->findAll();
        $this->assertEmpty($books);
    }
}
