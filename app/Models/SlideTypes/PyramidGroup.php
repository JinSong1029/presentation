<?php
/**
 * Date: 18.01.2016
 * Time: 14:33
 */

namespace App\Models\SlideTypes;


use App\Models\Slide;
use Illuminate\Database\Eloquent\Model;

class PyramidGroup extends Model
{
    protected $table = 'pyramid_groups';

    public function slides()
    {
        return $this->morphToMany(Slide::class, 'slideable')->withPivot('position');
    }
}