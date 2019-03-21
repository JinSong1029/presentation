<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Section extends Model
{

    protected $table = 'sections';

    protected $fillable   = ['name', 'ordering', 'section_id','additional'];
    public    $timestamps = false;
    protected $with       = ['slides'];

    public function presentation()
    {
        return $this->belongsTo(Presentation::class);
    }

    public function slides()
    {
        return $this->hasMany(Slide::class)->orderBy('ordering', 'ASC');
    }

    public function lastSlidePosition()
    {
        $first = $this->hasMany(Slide::class)->orderBy('ordering', 'DESC')->first();

        return $first ? $first->ordering + 1 : 1;
    }

    public function isIntro()
    {
        return $this->name == intro_page_name();
    }
}