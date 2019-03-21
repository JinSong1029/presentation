<?php
$I = new FunctionalTester($scenario);

$I->am('logged user');
$I->wantTo('remove section from presentation');
$I->amExistingLoggedUser(true, ['title'=>'Presentation'],true,1);

$I->amOnPage('/admin/presentations/1/edit');
$I->seeInTitle('Edit presentation');
$I->click('.fa-times');

$I->click('Delete section','a');
$I->sendAjaxPostRequest('/admin/sections/1/',['_method'=>'DELETE','_token'=>csrf_token()]);
$I->seeResponseCodeIs('200');

$this->assertCount(0, App\Models\Section::all());
$this->assertCount(0, App\Models\Slide::all());
$this->assertCount(0, App\Models\SlideTypes\Tombstone::all());
