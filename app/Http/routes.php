<?php


use App\Models\Section;

Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');
Route::get('auth/reset', 'Auth\PasswordController@getReset');
Route::get('/register', 'Auth\AuthController@getRegister');
Route::post('/register', 'Auth\AuthController@postRegister');
Route::post('/reset', 'Auth\PasswordController@reset');

if (\Config::get('app_mode') == 'dashboard') {
    Route::group(['prefix' => '', 'middleware' => ['auth']], function () {
        Route::get('', function () {
            return \Redirect::to('/presentations');
        });

        Route::resource('users', 'Admin\AdminUsersController');

        Route::get('presentations/test', function () {
            /** @var Section $section */
            $section = Section::find(18);
            dd($section->lastSlidePosition);

        });
        Route::get('presentations/changeTags', 'Admin\AdminPresentationsController@changeTags');

        Route::get('test', 'Admin\AdminSlidesController@test');
        Route::post('slides/{slides}/move', 'Admin\AdminSlidesController@move');
        Route::get('presentations/{presentations}/slides/{slides}/edit', 'Admin\AdminSlidesController@edit');

        Route::get('/presentations/{presentations}/preview', 'Admin\AdminPresentationsController@preview');
        Route::get('/presentations/{presentations}/menu-screen', 'Admin\AdminPresentationsController@menuScreen');
        Route::post('presentations/{presentations}/setActive', 'Admin\AdminPresentationsController@setActive');
        Route::post('presentations/{presentations}/setArchived', 'Admin\AdminPresentationsController@setArchived');
        Route::post('presentations/{presentations}/editKey', 'Admin\AdminPresentationsController@updateKey');
        Route::post('presentations/{presentations}/duplicate', 'Admin\AdminPresentationsController@duplicate');
        Route::get('presentations/{presentations}/editKey', 'Admin\AdminPresentationsController@keys');
        Route::get('presentations/archived', 'Admin\AdminPresentationsController@archived');
        Route::get('presentations/keys', 'Admin\AdminPresentationsController@keys');
        Route::get('presentations/select', 'Admin\AdminPresentationsController@select');
        

        Route::resource('presentations', 'Admin\AdminPresentationsController');
        Route::get('defaults/{defaults}/increase', [
            'uses' => 'Admin\AdminDefaultsController@increasePosition',
            'as'   => 'defaults.increase',
        ]);
        Route::get('defaults/{defaults}/decrease', [
            'uses' => 'Admin\AdminDefaultsController@decreasePosition',
            'as'   => 'defaults.increase',
        ]);
        Route::resource('defaults', 'Admin\AdminDefaultsController');
        Route::post('presentations/sections/sort', 'Admin\AdminSectionsController@sort');
        Route::resource('sections', 'Admin\AdminSectionsController');
        Route::post('presentations/slides/sort', 'Admin\AdminSlidesController@sort');
        Route::get('slides/{slides}/delete', 'Admin\AdminSlidesController@destroy');
        Route::post('slides/{slides}/deleteItem', 'Admin\AdminSlidesController@deleteItem');

        Route::post('slides/logos', [
            'uses' => 'Admin\AdminImagesController@storeLogos',
            'as'   => 'images.storeLogos',
        ]);

        Route::resource('icons', 'Admin\AdminIconsController');
        Route::post('slides/icons', [
            'uses' => 'Admin\AdminIconsController@storeLogos',
            'as'   => 'icons.storeLogos',
        ]);
        Route::PUT('slides/icons', [
            'uses' => 'Admin\AdminIconsController@storeLogos',
            'as'   => 'icons.updateLogos',
        ]);

        Route::post('slides/{slides}/changeColor', 'Admin\AdminSlidesController@changeColor');
        Route::post('slides/{slides}/saveLogo', 'Admin\AdminSlidesController@saveLogo');
        Route::post('slides/{slides}/deleteLogo', 'Admin\AdminSlidesController@deleteLogo');
        Route::post('slides/{slides}/reorderItems', 'Admin\AdminSlidesController@reorderItems');
        Route::resource('slides', 'Admin\AdminSlidesController');
        Route::resource('gallarys', 'Admin\AdminGallarysController');
        Route::resource('teams', 'Admin\AdminTeamsController');
        Route::resource('tombstones', 'Admin\AdminTombstonesController');
        Route::resource('pyramidGroups', 'Admin\AdminPyramidGroupsController');
        Route::resource('procedures', 'Admin\AdminProceduresController');
        Route::resource('splits', 'Admin\AdminSplitScreensController');
        Route::post('pictures/logos', 'Admin\AdminImagesController@getLogos');
        Route::post('pictures/icons', 'Admin\AdminIconsController@getLogos');
        Route::post('pictures/tombstones', 'Admin\AdminTombstonesController@getTombstones');
        Route::post('pictures/teams', 'Admin\AdminTeamsController@getTeams');

        Route::resource('pictures', 'Admin\AdminImagesController');
        Route::post('pictures', [
            'uses' => 'Admin\AdminImagesController@store',
            'as'   => 'images.store',
        ]);
        Route::put('pictures/{pictures}', [
            'uses' => 'Admin\AdminImagesController@update',
            'as'   => 'images.update',
        ]);
        Route::resource('texts', 'Admin\AdminTextsController');
        Route::resource('videos', 'Admin\AdminVideosController');
        Route::resource('quotes', 'Admin\AdminQuotesController');

    });
    Route::get('preview', 'PresentationController@index');
    Route::get('menu-screen', 'PresentationController@menuScreen');
    Route::post('presentations/set_session', 'PresentationController@setSession');
} else {
    Route::get('/', function () {
        return redirect()->to('/presentations');
    });
    //Route::post('presentations/{presentations}', 'PresentationController@checkKey');
    //Route::get('presentations/{presentations}/key', 'PresentationController@getKey');
    Route::post('/presentations/key', 'PresentationController@key');
    //Route::get('/presentations/key','PresentationController@show');
    Route::get('presentations', 'PresentationController@index');
    Route::get('presentations/menu-screen', 'PresentationController@menuScreen');
    Route::get('presentations/screen-intro', 'PresentationController@screenIntroTemplate');
    Route::get('presentations/contents', 'PresentationController@contentsTemplate');
    Route::get('presentations/logos_view', 'PresentationController@logosViewTemplate');
    Route::get('presentations/content_view', 'PresentationController@contentViewTemplate');
    Route::get('presentations/content_plain_view', 'PresentationController@contentPlainViewTemplate');
    Route::get('presentations/icons_view', 'PresentationController@iconsViewTemplate');
    Route::get('presentations/images_view', 'PresentationController@imagesViewTemplate');
    Route::get('presentations/team_view', 'PresentationController@teamViewTemplate');
    Route::get('presentations/tombstone_view', 'PresentationController@tombstoneViewTemplate');
    Route::get('presentations/full_image_view', 'PresentationController@fullImageViewTemplate');
    Route::get('presentations/full_video_view', 'PresentationController@fullVideoViewTemplate');
    Route::post('presentations/set_session', 'PresentationController@setSession');
    Route::get('presentations/guard', 'PresentationController@guard');
    Route::get('presentations/quit', 'PresentationController@quit');
    Route::group(['middleware' => ['authOrClient']], function () {
        //    Route::get('presentations/{presentations}', 'PresentationController@show');
    });

}