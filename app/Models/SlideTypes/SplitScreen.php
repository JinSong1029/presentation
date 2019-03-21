<?php

namespace App\Models\SlideTypes;


use App\Models\Slide;
use Illuminate\Database\Eloquent\Model;

class SplitScreen extends Model implements SliderContentInterface
{
    protected $table = 'splits';
    protected $fillable = ['text'];

    public function slides()
    {
        return $this->morphToMany(Slide::class, 'slideable');
    }

    public function createEmptySlideContent()
    {
        return SplitScreen::create();
    }
}