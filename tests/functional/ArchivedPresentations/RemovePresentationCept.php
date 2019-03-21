<?php
$I = new FunctionalTester($scenario);

$I->am('logged user');
$I->wantTo('remove presentation');
$I->amExistingLoggedUser(true,['archived'=>1],true);

$I->seeRecord('presentations',['id'=>1,'archived'=>1]);
$I->amOnPage('/admin/presentations/archived');

$I->click('.delete-row-action a');
$I->seeElement('input', ['value' => 'Remove']);

$I->click('.btn-danger');

$I->dontSeeRecord('presentations',['id'=>1]);
$this->assertCount(0, App\Models\Section::all());
$this->assertCount(0, App\Models\Slide::all());
$this->assertCount(0, App\Models\SlideTypes\Tombstone::all());
