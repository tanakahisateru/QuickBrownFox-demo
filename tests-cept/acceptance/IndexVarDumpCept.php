<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('see var_dump results');

$I->generateFixtures('books', 10, function ($i) {
    return [
        'title' => "Book - {$i}",
        'price' => $i * 100,
    ];
}, 1);

$I->amOnPage('/index.php');

$I->see('Book - 1');
$I->see('100');

$I->see('Book - 10');
$I->see('1000');
