<?php
$I = new FunctionalTester($scenario);

$I->am('logged user');
$I->wantTo('create new user without password');
$I->amExistingLoggedUser();

$I->tryToCreateUserWith(['name' => 'John doe']);
$I->dontSeeRecord('users', ['name' => 'John doe']);
$I->seeInTitle('Create new user');
$I->see('The password field is required.', 'div');
