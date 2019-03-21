<?php
$I = new FunctionalTester($scenario);

$I->am('logged user');
$I->wantTo('duplicate presentation');
$I->amExistingLoggedUser(true, ['title'=>'Presentation'], true);

$I->seeRecord('presentations', ['id' => 1]);
$this->assertCount(3, App\Models\Section::all());
$this->assertCount(9, App\Models\Slide::all());
$this->assertCount(9, App\Models\SlideTypes\Tombstone::all());

$I->amOnPage('/admin/presentations');
$I->seeResponseCodeIs('200');
$I->click('.duplicate-row-action a');
$I->sendAjaxPostRequest('/admin/presentations/1/duplicate',['_token'=>csrf_token()]);
$I->seeResponseCodeIs('200');
$I->seeRecord('presentations', ['id' => 2,'title'=>'Presentation - copy']);

$presentation = \App\Models\Presentation::find(1);
$newPresentation = \App\Models\Presentation::find(2);


$this->assertEquals($presentation->client,$newPresentation->client);
$this->assertCount(3, $newPresentation->sections->toArray());
$this->assertCount(9, $newPresentation->slides->toArray());
$this->assertCount(1, $newPresentation->slides[0]->slideables()->toArray());
