<?php
$I = new FunctionalTester($scenario);

$I->am('logged user');
$I->wantTo('refresh presentation key');
$I->amExistingLoggedUser(true,['key'=>'kdfQxE2xedUM2Dh4']);

$I->amOnPage('/admin/presentations/keys');

$I->seeRecord('presentations',['id'=>1,'author_id'=>1,'key'=>'kdfQxE2xedUM2Dh4']);
//$I->click(".refresh-row-action a");
$I->submitForm('#random_refresh1', []);

$I->dontSeeRecord('presentations',['id'=>1,'key'=>'kdfQxE2xedU1M2Dh4']);
$presentation = $I->grabRecord('presentations',['id'=>1]);
$this->assertEquals(16,strlen($presentation->key));

