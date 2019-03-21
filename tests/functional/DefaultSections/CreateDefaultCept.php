<?php
$I = new FunctionalTester($scenario);

$I->am('logged user');
$I->wantTo('create new default');
$I->amExistingLoggedUser();

$I->tryToCreateDefaultSection('New section');
$I->seeRecord('default_sections', ['name' => 'New section']);
$I->seeInTitle('Presentation defaults');
$I->see('New section', 'td');
