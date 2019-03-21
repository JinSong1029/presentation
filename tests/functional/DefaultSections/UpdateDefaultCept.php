<?php
$I = new FunctionalTester($scenario);

$I->am('logged user');
$I->wantTo('update default');
$I->haveDefaults(1);

$I->amExistingLoggedUser();

$I->amOnPage('/admin/defaults');
//dd(\URL::current());
$I->seeInTitle('Presentation defaults');
$I->seeRecord('default_sections',['id'=>1]);

$I->click('.edit-row-action a');
$I->seeInTitle('Edit defaults');
