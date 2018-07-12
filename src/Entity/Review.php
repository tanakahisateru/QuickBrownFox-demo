<?php

namespace Acme\App\Entity;


class Review
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $book_id;

    /**
     * @var float
     */
    public $rating;

    /**
     * @var Book
     */
    public $book;
}
