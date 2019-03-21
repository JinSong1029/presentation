<?php

namespace App\Models\SlideTypes;


use App\Models\Slide;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Video extends Model implements SliderContentInterface
{
    protected $table = 'videos';

    public function slides()
    {
        return $this->morphToMany(Slide::class, 'slideable');
    }
    public function createEmptySlideContent()
    {
        return Video::create();
    }

    public function getEmbed()
    {
        if(Str::contains($this->url,['vimeo']))
            return $this->url;

        $elements = explode('/', $this->url);
        $protocol = $elements[0];
        $code = end($elements);

        $code = str_replace('watch?v=','',$code);

        return $protocol . '//www.youtube.com/embed/' . $code;

    }
}