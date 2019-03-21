<?php
namespace App\Models\SlideTypes;


use App\Models\Slide;
use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    protected $table = 'procedures';

    protected $fillable = ['label','description'];


    public function slides()
    {
        return $this->morphToMany(Slide::class, 'slideable');
    }
}