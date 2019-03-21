<?php
$I = new FunctionalTester($scenario);

$I->am('logged user');
$I->wantTo('delete user');
$I->amExistingLoggedUser(true);

$I->amOnPage('/admin/users');

$I->seeRecord('presentations',['id'=>1,'author_id'=>1]);
$I->click('.fa-times');
$I->seeElement('input', ['value' => 'Remove']);

$I->click('.btn-danger');
$I->dontSeeRecord('users',['id'=>1]);
$I->seeRecord('presentations',['id'=>1,'author_id'=>null]);
$I->dontSee('.fa-times');

