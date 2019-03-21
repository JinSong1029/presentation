<?php

namespace App\Models\SlideTypes;


use App\Models\Slide;
use Illuminate\Database\Eloquent\Model;

class Gallary extends Model implements SliderContentInterface
{
    protected $table = 'gallarys';

    protected $fillable = ['label'];


    public function slides()
    {
        return $this->morphToMany(Slide::class, 'slideable');
    }

    public function createEmptySlideContent()
    {
        return Gallary::create();
    }
}