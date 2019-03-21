<?php
$I = new FunctionalTester($scenario);

$I->am('logged user');
$I->wantTo('manually edit presentation key');
$I->amExistingLoggedUser(true,['key'=>'kdfQxE2xedUM2Dh4']);

$I->amOnPage('/admin/presentations/keys');

$I->seeRecord('presentations',['id'=>1,'author_id'=>1,'key'=>'kdfQxE2xedUM2Dh4']);
$I->click('.edit-row-action a');
$I->seeInTitle('Edit client key');
$I->submitForm('#refresh_key', ['key'=>'NewClientKey']);

$I->SeeRecord('presentations',['id'=>1,'key'=>'NewClientKey']);

