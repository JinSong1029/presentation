<?php

namespace App\Models\SlideTypes;


use App\Models\Slide;
use Illuminate\Database\Eloquent\Model;

class Image extends Model implements SliderContentInterface
{

    protected $table = 'images';

    protected $fillable = ['name'];

    public function slides()
    {
        return $this->morphToMany(Slide::class, 'slideable');
    }


    public function createEmptySlideContent()
    {
     return Image::create();
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