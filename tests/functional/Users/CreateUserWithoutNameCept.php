<?php
$I = new FunctionalTester($scenario);

$I->am('logged user');
$I->wantTo('create new user without name');
$I->amExistingLoggedUser();

$I->tryToCreateUserWith(['password' => '123456']);
$I->dontSeeRecord('users', ['password' => bcrypt('123456')]);
$I->seeInTitle('Create new user');
$I->see('The name field is required.', 'div');
