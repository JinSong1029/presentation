<?php
namespace App\Models\Images;
use Step\Functional\Admin as AdminTester;

function time(){
    return 'time';
}
class CreateTombstoneCest
{
    public function _before(AdminTester $I)
    {
        $I->am('logged user');
        $I->wantTo('create tombstone');
        $I->onSlidesEditPage('tombstone');
    }

    // tests
    public function id_adds_tombstone_slide(AdminTester $I)
    {
        $I->submitTombstoneForm('Tombstone','Tombstone description','cepttestfile.jpg');
        $I->seeRecord('tombstones',['id'=>4,'label'=>'Tombstone','desc'=>'Tombstone description','image'=>'time-cepttestfile.jpg']);
        $I->assertFileExists(public_path('img/tombstones/time-cepttestfile.jpg'));
        $I->deleteFile(public_path('img/tombstones/time-cepttestfile.jpg'));
    }

    public function it_gives_an_error_if_tombstone_without_image(AdminTester $I)
    {
        $I->submitTombstoneForm('Tombstone','Tombstone description');
        $I->seeFormErrorMessage('image','The image is required');
    }
    public function it_gives_an_error_if_tombstone_has_wrong_extension(AdminTester $I)
    {
        $I->submitTombstoneForm('Tombstone','Tombstone description','wmotest.pdf');
        $I->seeFormErrorMessage('image','Wrong image extension, jpg,jpeg,bmp,png,gif allowed');
    }
}
