<?php

use Step\Functional\Admin as AdminTester;


class UpdatePictureCest
{
    public function _before(AdminTester $I)
    {
//        $I->am('logged user');
//        $I->wantTo('update picture');
//        $I->onSlidesEditPage('picture');
//        $I->submitPictureForm('Image', null, 'testfile.jpg');
//        $I->seeRecord('images',['id'=>1,'name'=>null,'image'=>'time-testfile.jpg']);
//        $I->assertFileExists(public_path('img/images/time-testfile.jpg'));
//        $I->amOnPage('/admin/presentations/1/slides/4/edit?subslide=1');
    }

    public function _after(AdminTester $I)
    {
        $I->cleanupFiles('tombstones');
    }

    //tests
    public function it_updates_image_of_picture_slide(AdminTester $I)
    {
//        $I->attachFile('input[type="file"]', 'cepttestfile.jpg');
//        $I->click('Save - return to presentation');
////        dd(Image::all());
//
//        $I->seeRecord('images',['id'=>1]);
//        $I->assertFileExists(public_path('img/images/time-cepttestfile.jpg'));
//        $I->assertFileNotExists(public_path('img/images/time-testfile.jpg'));
        //TODO find out how it deletes all images after click
    }
}
