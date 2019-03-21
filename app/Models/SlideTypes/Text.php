<?php

namespace App\Models\SlideTypes;


use App\Models\Slide;
use Illuminate\Database\Eloquent\Model;

class Text extends Model implements SliderContentInterface
{

    protected $table = 'texts';

    protected $fillable = ['text'];

    public function slides()
    {
        return $this->morphToMany(Slide::class, 'slideable');
    }
    public function createEmptySlideContent()
    {
        return Text::create();
    }
}