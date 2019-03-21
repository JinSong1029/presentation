<?php
$I = new FunctionalTester($scenario);

$I->am('logged user');
$I->wantTo('activate presentation');
$I->amExistingLoggedUser(true,['archived'=>0]);

$I->seeRecord('presentations',['id'=>1,'archived'=>0]);
$I->amOnPage('/admin/presentations');
$I->seeResponseCodeIs('200');
$I->click('.lock-row-action a');
$I->sendAjaxPostRequest('/admin/presentations/1/setArchived',['archived'=>1,'_token'=>csrf_token()]);
$I->seeResponseCodeIs('200');

$I->dontSee('.fa-unlock');
$I->seeRecord('presentations',['id'=>1,'archived'=>1]);