<?php
namespace Step\Functional;

use File;
class Admin extends \FunctionalTester
{

    public function submitTombstoneForm($label, $desc, $image = null)
    {
        $I = $this;
        $I->fillField('label', $label);
        $I->fillField('desc', $desc);
        $I->fillField('double', 0);
        if ($image != null) {
            $I->attachFile('input[type="file"]', $image);
        }
        $I->click('Save - add another tombstone');
    }
    public function submitPictureForm($name, $logo=null, $image = null)
    {
        $I = $this;
        $I->fillField('name', $name);
        $I->fillField('logo', $logo);
        if ($image != null) {
            $I->attachFile('input[type="file"]', $image);
        }
        $I->click('Save - add another image');
    }
    public function submitVideoForm($title, $url, $image = null)
    {
        $I = $this;
        $I->fillField('title', $title);
        $I->fillField('url', $url);
        if ($image != null) {
            $I->attachFile('input[type="file"]', $image);
        }
        $I->click('Save - return to presentation');
    }

    public function onSlidesEditPage($slideType)
    {
        $I = $this;
        $I->amExistingLoggedUser(true, ['title' => 'Presentation'], true, 1);
        $I->seeRecord('presentations', ['id' => 1, 'archived' => 0]);
        $I->amOnPage('/admin/presentations/1/edit');
        $I->submitForm('#add_slide_1', ['name' => 'New slide', 'slideType' => $slideType]);
        $I->seeRecord('slides', ['id' => 4, 'name' => 'New slide', 'type' => $slideType]);
        $I->amOnPage('/admin/presentations/1/slides/4/edit');
        $I->seeInTitle('Edit presentation slides');
    }

    public function cleanupFiles($folder)
    {
        $I=$this;
        if (File::exists(public_path('img/'.$folder.'/time-testfile.jpg'))) {
            $I->deleteFile(public_path('img/'.$folder.'/time-testfile.jpg'));
        }

        if (File::exists(public_path('img/'.$folder.'/time-cepttestfile.jpg'))) {
            $I->deleteFile(public_path('img/'.$folder.'/time-cepttestfile.jpg'));
        }
    }
}