<?php
$I = new FunctionalTester($scenario);

$I->am('logged user');
$I->wantTo('remove default');
$I->haveDefaults(1);

$I->amExistingLoggedUser();

$I->amOnPage('/admin/defaults');
//dd(\URL::current());
$I->seeInTitle('Presentation defaults');
$I->seeRecord('default_sections',['id'=>1]);


$I->click('.fa-times');
$I->seeElement('input', ['value' => 'Remove']);

$I->click('.btn-danger');
$I->dontSeeRecord('default_sections',['id'=>1]);
$I->dontSee('.fa-times');
