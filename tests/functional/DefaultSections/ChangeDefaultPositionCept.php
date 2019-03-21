<?php
$I = new FunctionalTester($scenario);

$I->am('logged user');
$I->wantTo('remove default');
$I->haveDefaults(2);

$I->amExistingLoggedUser();

$I->amOnPage('/admin/defaults');

$I->seeInTitle('Presentation defaults');
$I->seeRecord('default_sections',['id'=>1,'ordering'=>1]);

$I->seeElement('#downlink1');
//
$I->click(".move-row-action a");
//
$I->SeeRecord('default_sections',['id'=>1,'ordering'=>2]);
$I->SeeRecord('default_sections',['id'=>2,'ordering'=>1]);

