<?php

use Step\Functional\Admin as AdminTester;

class UpdateTombstoneCest
{
    public function _after(AdminTester $I)
    {
        $I->cleanupFiles('tombstones');
    }
    public function _before(AdminTester $I)
    {
        $I->am('logged user');
        $I->wantTo('update tombstone');
        $I->onSlidesEditPage('tombstone');
        $I->submitTombstoneForm('new tomb', 'desc', 'testfile.jpg');
        $I->seeRecord('tombstones', ['id' => 4, 'label' => 'new tomb', 'desc' => 'desc', 'image' => 'time-testfile.jpg']);
        $I->amOnPage('/admin/presentations/1/slides/4/edit?subslide=4');
        $I->see('new tomb', 'div');
        $I->see('desc', 'div');
    }

    // tests
    public function it_updates_tombstone_with_image(AdminTester $I)
    {
        $I->fillField('label', 'Updated tomb');
        $I->fillField('desc', 'Updated desc');
        $I->attachFile('input[type="file"]', 'cepttestfile.jpg');
        $I->click('Save - add another tombstone');
        $I->assertFileExists(public_path('img/tombstones/time-cepttestfile.jpg'));
        $I->assertFileNotExists(public_path('img/tombstones/time-testfile.jpg'));
        $I->seeRecord('tombstones', ['id' => 4, 'label' => 'Updated tomb', 'desc' => 'Updated desc', 'image' => 'time-cepttestfile.jpg']);

    }

    public function it_shows_message_if_file_format_is_incorrect(AdminTester $I)
    {
        $I->submitTombstoneForm('Tombstone','Tombstone description','wmotest.pdf');
        $I->seeFormErrorMessage('image','Wrong image extension, jpg,jpeg,bmp,png,gif allowed');

    }
}
