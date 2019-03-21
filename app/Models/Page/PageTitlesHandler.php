<?php

namespace App\Models\Page;

class PageTitlesHandler
{
    public $pageTitlesCollection = [
        'users/create'=>'Create new user',
        'users'=>'Users',
        'users/{users}/edit'=>'Edit user',
        '/'=>'Home',
        'auth/login'=>'Login',
        'presentations/{presentations}' => 'Presentation',
        'presentations/guard' => 'Enter key',
        'presentations' => 'Presentation preview',
        'presentations/{presentations}/key'=>'Enter your key',
        'presentations/create'=>'Create presentation',
        'defaults'=>'Presentation defaults',
        'defaults/create'=>'Create new default',
        'defaults/{defaults}/edit'=>'Edit defaults',
        'presentations/{presentations}/edit'=>'Edit presentation',
        'slides/create'=>'Create slide',
        'slides/{slides}/edit'=>'Edit slide',
        'presentations/test'=>'Presentations',
        'preview'=>'Presentation',
        'menu-screen' =>'Presentation Menu',
        'presentations/archived'=>'Archived presentations',
        'presentations/select'=>'Select the active presentation',
        'presentations/keys' =>'Client keys',
        'presentations/menu-screen' =>'Walker Morris',
        'presentations/screen-intro' =>'Walker Morris',
        'presentations/contents' =>'Walker Morris',
        'presentations/logos_view' =>'Walker Morris',
        'presentations/content_view' =>'Walker Morris',
        'presentations/content_plain_view' =>'Walker Morris',
        'presentations/icons_view' =>'Walker Morris',
        'presentations/images_view' =>'Walker Morris',
        'presentations/team_view' =>'Walker Morris',
        'presentations/tombstone_view' =>'Walker Morris',
        'presentations/full_image_view' =>'Walker Morris',
        'presentations/full_video_view' =>'Walker Morris',
        'presentations/{presentations}/editKey'=>'Edit client key',
        'presentations/{presentations}/slides/{slides}/edit'=>'Edit presentation slides',
        'notFound'=>'Page not found'

    ];

    public function getTitle($uri)
    {
//        dd($this->pageTitlesCollection[$uri]);
        return $this->pageTitlesCollection[$uri];
    }
}