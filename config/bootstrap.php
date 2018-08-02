<?php

use Acme\App\TheApp;
use Aura\Di\ContainerBuilder;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

require __DIR__ . '/../vendor/autoload.php';

$di = (new ContainerBuilder())->newInstance();
TheApp::$container = $di;

$di->set(Connection::class, $di->lazy(function () {
    return DriverManager::getConnection([
        'url' => 'mysql://root:rootpass@127.0.0.1/qbf_demo?charset=UTF8',
        // 'url' => 'pgsql://postgres:postgrespass@localhost/qbf_demo?charset=UTF8',
        'driverOptions' => [
            // PDO::ATTR_EMULATE_PREPARES => 0,
        ],
    ]);
}));
