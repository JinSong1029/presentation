<?php
$I = new FunctionalTester($scenario);

$I->am('logged user');
$I->wantTo('activate presentation');
$I->amExistingLoggedUser(true);

;
$I->amOnPage('/admin/presentations/select');

$I->click('.check-row-action a');
$I->sendAjaxPostRequest('/admin/presentations/1/setActive',['active'=>1,'_token'=>csrf_token()]);
$I->seeResponseCodeIs('200');


$I->seeRecord('users',['id'=>1,'presentation_id'=>1]);

$I->click('.check-row-action a');
$I->sendAjaxPostRequest('/admin/presentations/1/setActive',['active'=>0,'_token'=>csrf_token()]);
$I->seeResponseCodeIs('200');

$I->seeRecord('users',['id'=>1,'presentation_id'=>null]);
