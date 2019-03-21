<?php
$I = new FunctionalTester($scenario);

$I->am('logged user');
$I->wantTo('update section and check validation');
$I->amExistingLoggedUser(true, ['title'=>'Presentation'],true,1);

$I->amOnPage('/admin/presentations/1/edit');
$I->seeInTitle('Edit presentation');
$I->click('.edit_section a');
$I->sendAjaxPostRequest('/admin/sections/1/',['_method'=>'PUT','_token'=>csrf_token(),'name'=>'']);
$I->seeResponseCodeIs('422');
$I->sendAjaxPostRequest('/admin/sections/1/',['_method'=>'PUT','_token'=>csrf_token(),'name'=>'New section name']);
$I->seeResponseCodeIs('200');
$I->seeRecord('sections',['id'=>1,'name'=>'New section name']);