<?php

namespace App\Models\SlideTypes;


use Illuminate\Database\Eloquent\Model;

class SlideType extends Model
{
    protected $table = 'slide_types';

    public function toSelect()
    {
       return SlideType::all()->lists('description','name')->toArray();
    }
}