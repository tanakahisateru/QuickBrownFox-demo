<?php

namespace Acme\App\Repository;

use Acme\App\Entity\Review;
use Acme\App\TheApp;
use Doctrine\DBAL\Connection;
use Lapaz\QuickBrownFox\Database\FixtureSetupSession;
use Lapaz\QuickBrownFox\Database\SessionManager;
use PHPUnit\Framework\TestCase;

class ReviewRepositoryTest extends TestCase
{
    /**
     * @var FixtureSetupSession
     */
    protected $data;

    /**
     * @var ReviewRepository
     */
    private $reviewRepository;

    /**
     * @var BookRepository
     */
    private $bookRepository;

    protected function setUp()
    {
        $this->bookRepository = new BookRepository(TheApp::$container->get(Connection::class));

        $this->reviewRepository = new ReviewRepository(
            TheApp::$container->get(Connection::class),
            $this->bookRepository
        );

        $this->data = TheApp::$container->get(SessionManager::class)->newSession();
    }

    public function testNothing()
    {
        $this->data->into('authors')->generate(5);

        $this->data->into('books')->with('cheap')->generate(3);
        $this->data->into('books')->with('expensive')->generate(2);

        $this->data->into('reviews')->generate(100);

        $this->assertCount(5, $this->bookRepository->findAll());
    }

    public function testFindAllByBook()
    {
        $book_ids = $this->data->into('books')->load([
            ['title' => 'Perfect PHP'],
            ['title' => 'Perfect Java'],
            ['title' => 'Perfect Ruby'],
        ]);

        list($phpBookId, $javaBookId, $rubyBookId) = $book_ids;

        $this->data->into('reviews')->load([
            ['book_id' => $phpBookId, 'rating' => 3.5],
            ['book_id' => $phpBookId, 'rating' => 4.0],
            ['book_id' => $phpBookId, 'rating' => 4.5],

            ['book_id' => $javaBookId, 'rating' => 3.0],
        ]);

        /** @noinspection PhpExpressionResultUnusedInspection */
        $rubyBookId;

        // 3 reviews to PHP
        $book = $this->bookRepository->findOneByTitle('Perfect PHP');

        $reviews = $this->reviewRepository->findAllByBook($book, false);
        $this->assertCount(3, $reviews);
        $this->assertEquals('Perfect PHP', $reviews[0]->book->title);
        $this->assertEquals('Perfect PHP', $reviews[1]->book->title);
        $this->assertEquals('Perfect PHP', $reviews[2]->book->title);

        $average = array_sum(array_map(function (Review $review) {
            return $review->rating;
        }, $reviews)) / count($reviews);

        $this->assertEquals(4.0, $average);

        // 1 review to Java
        $book = $this->bookRepository->findOneByTitle('Perfect Java');

        $reviews = $this->reviewRepository->findAllByBook($book, false);
        $this->assertCount(1, $reviews);
        $this->assertEquals('Perfect Java', $reviews[0]->book->title);

        // 0 reviews to Ruby
        $book = $this->bookRepository->findOneByTitle('Perfect Ruby');

        $reviews = $this->reviewRepository->findAllByBook($book, false);
        $this->assertCount(0, $reviews);
    }
}
