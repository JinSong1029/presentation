<?php

namespace App\Models\SlideTypes;


use App\Models\Slide;
use Illuminate\Database\Eloquent\Model;

class Team extends Model implements SliderContentInterface
{
    protected $table = 'teams';

    protected $fillable = ['label','desc'];


    public function slides()
    {
        return $this->morphToMany(Slide::class, 'slideable');
    }

    public function createEmptySlideContent()
    {
        return Team::create();
    }
}