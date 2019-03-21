<?php

namespace App\Models\SlideTypes;


use App\Models\Slide;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $table = 'quotes';
    protected $fillable = ['quote'];

    public function slides()
    {
        return $this->morphToMany(Slide::class, 'slideable');
    }
}