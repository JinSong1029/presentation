<?php
$I = new FunctionalTester($scenario);

$I->am('logged user');
$I->wantTo('create various types of slide with validation check');
$I->amExistingLoggedUser(true, ['title'=>'Presentation'],true,1);

$I->amOnPage('/admin/presentations/1/edit');
$I->seeInTitle('Edit presentation');

$I->click('.morris-presentation-slide-add');

$I->submitForm('#add_slide_1', ['name' =>'New slide','slideType'=>'logo']);
$I->seeRecord('slides',['id'=>4,'name'=>'New slide','type'=>'logo']);


$I->submitForm('#add_slide_1', ['name' =>'New slide','slideType'=>'tombstone']);
$I->seeRecord('slides',['id'=>5,'name'=>'New slide','type'=>'tombstone']);


$I->submitForm('#add_slide_1', ['name' =>'New slide','slideType'=>'video']);
$I->seeRecord('slides',['id'=>6,'name'=>'New slide','type'=>'video']);
$I->seeRecord('videos',['id'=>1,'image'=>null,'title'=>null,'url'=>null]);

$I->submitForm('#add_slide_1', ['name' =>'New slide','slideType'=>'text']);
$I->seeRecord('slides',['id'=>7,'name'=>'New slide','type'=>'text']);
$I->seeRecord('texts',['id'=>1,'text'=>null]);

$I->submitForm('#add_slide_1', ['name' =>'New slide','slideType'=>'picture']);
$I->seeRecord('slides',['id'=>8,'name'=>'New slide','type'=>'picture']);



$I->submitForm('#add_slide_1', ['name' =>'','slideType'=>'logo']);
$I->seeFormErrorMessage('name', 'The name field is required.');