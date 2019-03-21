<?php

namespace App\Models\SlideTypes;


use App\Models\Slide;
use Illuminate\Database\Eloquent\Model;

class Tombstone extends Model implements SliderContentInterface
{
    protected $table = 'tombstones';

    protected $fillable = ['label']; // , 'desc'


    public function slides()
    {
        return $this->morphToMany(Slide::class, 'slideable');
    }

    public function createEmptySlideContent()
    {
        return Tombstone::create();
    }
}