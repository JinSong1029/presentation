<?php

namespace App\Providers;

use App\CustomValidators\CustomValidator;
use App\Models\Images\ImageHandler;
use App\Models\Presentation;
use App\Models\Section;
use App\Models\Slide;
use App\Models\SlideTypes\Image;
use App\Models\SlideTypes\PyramidGroup;
use App\Models\SlideTypes\Quote;
use App\Models\SlideTypes\Tombstone;
use App\Models\SlideTypes\Video;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @param ImageHandler $handler
     */
    public function boot(ImageHandler $handler)
    {
        Presentation::deleting(function ($presentation) {
            foreach ($presentation->sections as $section) {
                foreach ($section->slides as $slide) {
                    foreach ($slide->slideables() as $slideable) {
                        $slideable->delete();
                    }
                    $slide->delete();
                }
                $section->delete();
            }
            $presentation->sections()->delete();
        });
        Section::deleting(function ($section) {
            foreach ($section->slides as $slide) {
                foreach ($slide->slideables() as $slideable) {
                    $slideable->slides()->detach();
                    $slideable->delete();
                }
                $slide->delete();
            }
        });
        Slide::deleted(function ($slide) {
            foreach ($slide->slideables() as $slideable) {
                $slideable->slides()->detach();
                $slideable->delete();
            }
        });
        Tombstone::deleting(function ($tombstone) use ($handler) {
            $tombstone->slides()->detach();
            $handler->deleteImage($tombstone->image, 'tombstones');
        });
        Image::deleting(function ($image) use ($handler) {
            $image->slides()->detach();
            $handler->deleteImage($image->image, 'images');
        });
        Video::deleting(function ($video) use ($handler) {
            $video->slides()->detach();
            $handler->deleteImage($video->image, 'videos');
        });
        Quote::deleting(function ($quote) use ($handler) {
            $quote->slides()->detach();
            $handler->deleteImage($quote->image, 'quotes');
        });
        PyramidGroup::deleting(function ($group) use ($handler) {
            $group->slides()->detach();
        });

        User::deleting(function ($user) {
            $user->roles()->detach();
            $user->presentations()->update(['author_id' => null]);
        });

        Validator::resolver(function($translator, $data, $rules, $messages)
        {
            return new CustomValidator($translator, $data, $rules, $messages);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
