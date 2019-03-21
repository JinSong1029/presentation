<?php
$I = new FunctionalTester($scenario);
$I->am('logged user');
$I->wantTo('create presentation and check validation');
$I->amExistingLoggedUser();
$I->haveDefaults('3');

$I->amOnPage('/admin/presentations/create');

$I->seeInTitle('Create presentation');

$I->submitForm('#create_presentation', ['title' => 'First presentation', 'client' => '']);
$I->seeFormErrorMessage('client', 'The client field is required.');

$I->submitForm('#create_presentation', ['title' => '', 'client' => 'First client']);
$I->seeFormErrorMessage('title', 'The title field is required.');

$I->submitForm('#create_presentation', ['title' => '', 'client' => '']);
$I->seeFormErrorMessages(['title' => 'The title field is required.', 'client' => 'The client field is required.']);

$I->submitForm('#create_presentation', ['title' => 'First presentation', 'client' => 'First client']);
$I->seeRecord('presentations', ['id' => 1, 'title' => 'First presentation', 'client' => 'First client']);
$presentation = \App\Models\Presentation::find(1);
$section = \App\Models\Presentation\DefaultSections::find(3);
$this->assertCount(3, $presentation->sections->toArray());
$this->assertEquals($section->name, $presentation->sections[2]->name);

