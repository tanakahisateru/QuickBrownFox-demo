<?php

use Acme\App\Repository\BookRepository;
use Acme\App\TheApp;
use Doctrine\DBAL\Connection;

require __DIR__ . '/../config/bootstrap.php';

$bookRepository = new BookRepository(TheApp::$container->get(Connection::class));
$books = $bookRepository->findAll();

var_dump($books);
