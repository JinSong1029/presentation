<?php

use Step\Functional\Admin as AdminTester;

class CreatePictureCest
{
    public function _before(AdminTester $I)
    {
        $I->am('logged user');
        $I->wantTo('create picture');
        $I->onSlidesEditPage('picture');
    }

    public function _after(AdminTester $I)
    {
        $I->cleanupFiles('images');
    }

    // tests
//    public function id_adds_picture_slide(AdminTester $I)
//    {
//        $I->submitPictureForm('Image',null,'testfile.jpg');
//        $I->seeRecord('images',['id'=>1,'name'=>null,'image'=>'time-testfile.jpg']);
//        $I->assertFileExists(public_path('img/images/time-testfile.jpg'));
//    }
//    public function id_adds_picture_with_logo_slide(AdminTester $I)
//    {
//        $I->submitPictureForm('Client logo','Logo','testfile.jpg');
//        $I->seeRecord('images',['id'=>1,'name'=>'Logo','image'=>'time-testfile.jpg']);
//        $I->assertFileExists(public_path('img/images/time-testfile.jpg'));
//    }
//    public function id_gives_an_error_when_adding_picture_with_logo_slide_with_empty_client_logo_input(AdminTester $I)
//    {
//        $I->submitPictureForm('Client logo','','testfile.jpg');
//        $I->seeFormErrorMessage('logo','Logo name field is required');
//    }
//    public function it_gives_an_error_if_picture_without_image(AdminTester $I)
//    {
//        $I->submitPictureForm('Client logo','Tombstone');
//        $I->seeFormErrorMessage('image','The image field is required.');
//    }
//    public function it_gives_an_error_if_picture_has_wrong_extension(AdminTester $I)
//    {
//        $I->submitPictureForm('Image','Tombstone','wmotest.pdf');
//        $I->seeFormErrorMessage('image','The image must be a file of type: jpg, jpeg, bmp, png, gif.');
//    }
}
