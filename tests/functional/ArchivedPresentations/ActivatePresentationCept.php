<?php
$I = new FunctionalTester($scenario);

$I->am('logged user');
$I->wantTo('activate presentation');
$I->amExistingLoggedUser(true,['archived'=>1]);

$I->seeRecord('presentations',['id'=>1,'archived'=>1]);
$I->amOnPage('/admin/presentations/archived');
$I->seeResponseCodeIs('200');
$I->click('.lock-row-action a');
$I->sendAjaxPostRequest('/admin/presentations/1/setArchived',['archived'=>0,'_token'=>csrf_token()]);
$I->seeResponseCodeIs('200');

$I->dontSee('.fa-unlock');
$I->seeRecord('presentations',['id'=>1,'archived'=>0]);