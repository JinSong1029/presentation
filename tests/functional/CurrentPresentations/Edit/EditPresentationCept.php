<?php
$I = new FunctionalTester($scenario);

$I->am('logged user');
$I->wantTo('edit presentation');
$I->amExistingLoggedUser(true, ['title'=>'Presentation']);

$I->tryToUpdatePresentationUsingForm('New title','New client');
$I->seeRecord('presentations',['id'=>1,'title'=>'New title','client'=>'New client']);