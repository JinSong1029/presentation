<?php
namespace Helper;
// here you can define custom actions
// all public methods declared in helper class will be available in $I

use App\Models\Presentation;
use App\Models\Presentation\DefaultSections;
use App\Models\Section;
use App\Models\Slide;
use App\Models\SlideTypes\Tombstone;
use App\Models\User;
use Auth;

class Functional extends \Codeception\Module
{
    public function tryToCreateUserWith($data)
    {
        $I = $this->getModule('Laravel5');
        $I->amOnPage('/admin/users');
        $I->click('Create new user', 'a');
        $I->seeInTitle('Create new user');

        $I->submitForm('#create_user', $data);
    }

    public function amExistingLoggedUser($with = false, $overrides = [], $withChild = false, $sectionsCount = 3)
    {
        $user = factory(User::class, 1)->create(['id' => 1, 'name' => 'Tester']);
        $user->attachRole(1);
        Auth::loginUsingId(1);
        if ($with) {
            $presentation = factory(Presentation::class, 1)->create($overrides);
            $user->presentations()->save($presentation);
            if ($withChild) {
                $this->haveFullPresentation($presentation, $sectionsCount);
            }
        }
        return $user;
    }

    public function haveUsers()
    {

    }

    public function tryToUpdateUserWith($user, $data)
    {
        $I = $this->getModule('Laravel5');

        $I->amOnPage('/admin/users');
        $I->seeElement('.fa-pencil');
        $I->click('.edit-row-action a');
        $I->see('Edit user', 'h2');
        $I->seeInFormFields('#update_user', [
            'name' => $user->name,        // passes if checked
        ]);
        $I->submitForm('#update_user', $data);
    }

    public function tryToCreateDefaultSection($name)
    {
        $I = $this->getModule('Laravel5');

        $I->amOnPage('/admin/defaults');
        $I->click('Create new default', 'a');
        $I->seeInTitle('Create new default');

        $I->submitForm('#create_default_section', ['name' => $name]);
    }

    public function tryToUpdatePresentationUsingForm($title, $client)
    {
        $I = $this->getModule('Laravel5');

        $I->amOnPage('/admin/presentations');
        $I->click('.edit-row-action a');
        $I->seeInTitle('Edit presentation');

        $I->submitForm('#edit_presentation', ['title' => $title, 'client' => $client]);
    }

    public function haveDefaults($count)
    {
        foreach (range(1, $count) as $index) {
            $default = factory(DefaultSections::class)->create();
            $default->ordering = $index;
            $default->update();
        }

    }

    public function haveFullPresentation($presentation, $sectionsCount)
    {
        if ($sectionsCount > 1) {
            $sections = factory(Section::class, $sectionsCount)
                ->create()
                ->each(function ($section) {
                    $section->slides()->saveMany(
                        factory(Slide::class, 3)->create()->each(function ($slide) {
                            $slide->tombstones()->save(factory(Tombstone::class)->create());
                        })
                    );
                });
            $presentation->sections()->saveMany($sections);
        }
        else{
            $sections =   $sections = factory(Section::class, $sectionsCount)->create();
            $sections->slides()->saveMany(
                factory(Slide::class, 3)->create()->each(function ($slide) {
                    $slide->tombstones()->save(factory(Tombstone::class)->create());
                })
            );
            $presentation->sections()->save($sections);
        }

    }
}
