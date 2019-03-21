<?php
$I = new FunctionalTester($scenario);

$I->am('logged user');
$I->wantTo('create new user');
$I->amExistingLoggedUser();

$I->tryToCreateUserWith(['name' => 'John doe','password'=>'123456']);
$I->seeRecord('users', ['name' => 'John doe']);
$I->seeInTitle('Users');
