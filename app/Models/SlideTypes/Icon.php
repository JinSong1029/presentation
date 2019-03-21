<?php

namespace App\Models\SlideTypes;


use App\Models\Slide;
use Illuminate\Database\Eloquent\Model;

class Icon extends Model implements SliderContentInterface
{

    protected $table = 'icons';

    protected $fillable = ['name'];

    public function slides()
    {
        return $this->morphToMany(Slide::class, 'slideable');
    }


    public function createEmptySlideContent()
    {
     return Icon::create();
    }

    public function scopeLogos($query)
    {
        return $query->whereNotNull('name');
    }

    public function scopeExceptIds($query,$ids)
    {
       return  $query->whereNotIn('id',$ids);
    }
}