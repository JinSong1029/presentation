<?php
$I = new FunctionalTester($scenario);

$I->am('logged user');
$I->wantTo('create new user without password');
$user = $I->amExistingLoggedUser();

$I->tryToUpdateUserWith($user,['name' => 'John doe']);
$I->seeRecord('users', ['name' => 'John doe']);
$I->seeInTitle('User');
