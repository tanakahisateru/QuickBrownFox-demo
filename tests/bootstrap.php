<?php

use Doctrine\DBAL\Connection;
use Lapaz\QuickBrownFox\Context\TableDefinition;
use Lapaz\QuickBrownFox\Database\SessionManager;
use Lapaz\QuickBrownFox\FixtureManager;

require __DIR__ . '/../config/bootstrap.php';

$di->set(SessionManager::class, $di->lazy(function () use ($di) {
    $fixtures = new FixtureManager();

    $faker = $fixtures->getRandomValueGenerator();

    $fixtures->table('books', function (TableDefinition $d) use ($faker) {
        $d->defaults()->define([
            'title' => function () use ($faker) { return rtrim($faker->sentence, '.'); },
            'price' => function () { return mt_rand(2000, 10000); },
        ]);
        $d->generator('cheap')->define([
            'price' => function () { return mt_rand(1, 1000); },
        ]);
        $d->generator('expensive')->define([
            'price' => function () { return mt_rand(5000, 15000); },
        ]);
    });

    $fixtures->table('reviews', function (TableDefinition $d) {
        $d->defaults()->define([
            'rating' => function () { return mt_rand(2, 10) / 2.0; },
        ]);
    });

    $fixtures->table('authors', function (TableDefinition $d) use ($faker) {
        $d->defaults()->define([
            'name' => function () use ($faker) { return $faker->name; },
        ]);
    });
    $fixtures->table('publishers', function (TableDefinition $d) use ($faker) {
        $d->defaults()->define([
            'name' => function () use ($faker) { return $faker->company; },
        ]);
    });
    $fixtures->table('reviewers', function (TableDefinition $d) use ($faker) {
        $d->defaults()->define([
            'name' => function () use ($faker) { return $faker->name; },
        ]);
    });

    return $fixtures->createSessionManager($di->get(Connection::class));
}));
