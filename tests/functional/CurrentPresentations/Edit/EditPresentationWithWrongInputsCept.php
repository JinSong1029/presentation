<?php

$I = new FunctionalTester($scenario);

$I->am('logged user');
$I->wantTo('check edit presentation validation');
$I->amExistingLoggedUser(true, ['title' => 'Presentation']);

$I->tryToUpdatePresentationUsingForm('New title', '');
$I->seeFormErrorMessage('client', 'The client field is required.');

$I->tryToUpdatePresentationUsingForm('', 'Client');
$I->seeFormErrorMessage('title', 'The title field is required.');

$I->tryToUpdatePresentationUsingForm('', '');
$I->seeFormErrorMessages(['title' => 'The title field is required.', 'client' => 'The client field is required.']);