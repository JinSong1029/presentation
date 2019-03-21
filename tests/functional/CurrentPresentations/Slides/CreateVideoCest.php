<?php

use Step\Functional\Admin as AdminTester;

class CreateVideoCest
{
    public function _before(AdminTester $I)
    {
        $I->am('logged user');
        $I->wantTo('create picture');
        $I->onSlidesEditPage('video');
    }

    public function _after(AdminTester $I)
    {
        $I->cleanupFiles('videos');
    }

    // tests
    public function it_adds_video_slide(AdminTester $I)
    {
        $I->submitVideoForm('Title','http://codeception.com','testfile.jpg');
        $I->seeRecord('videos',['id'=>1,'title'=>'Title','image'=>'time-testfile.jpg','url'=>'http://codeception.com']);
        $I->assertFileExists(public_path('img/videos/time-testfile.jpg'));
    }
    public function it_gives_message_when_adds_video_slide_with_wrong_url(AdminTester $I)
    {
        $I->submitVideoForm('Title','wrong type of url','testfile.jpg');
        $I->seeFormErrorMessage('url','The url format is invalid.');
    }
    public function it_gives_message_when_adds_video_slide_without_title(AdminTester $I)
    {
        $I->submitVideoForm('','wrong type of url','testfile.jpg');
        $I->seeFormErrorMessage('title','The title field is required.');
    }
    public function it_gives_an_error_if_picture_without_image(AdminTester $I)
    {
        $I->submitVideoForm('','wrong type of url');
        $I->seeFormErrorMessage('image','The image is required');
    }
}
