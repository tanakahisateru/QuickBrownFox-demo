<?php

namespace Acme\App\Entity;


class Book
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var float
     */
    public $price;

    /**
     * @var string
     */
    public $description;

    /**
     * @var \DateTime
     */
    public $updated_at;
}