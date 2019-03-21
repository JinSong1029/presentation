<?php

namespace App\Models;


use App\Models\Presentation\DefaultSections;
use App\Models\Presentation\PresentationPresenter;
use App\Traits\SluggableTrait;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Presentation extends Model
{
    use PresentableTrait, SluggableTrait;

    protected $table = 'presentations';

    protected $presenter = PresentationPresenter::class;

    protected $fillable = ['title', 'client'];

    protected $with = ['sections'];

    const DEFAULT_COLOR = [
        'red'=>0,
        'green'=>70,
        'blue'=>76,
    ];

    protected $sluggable = [
        'build_from' => 'title',
        'save_to'    => 'slug',
    ];

    public function sections()
    {
        return $this->hasMany(Section::class)->orderBy('ordering', 'ASC');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopeOfActiveState($query, $active)
    {
        if ($active === null) {
            return $query;
        }

        return $query->where('archived', '=', $active);
    }

    public function activeUsers()
    {
        return $this->hasMany(User::class);
    }

    public function slides()
    {
        return $this->hasManyThrough(Slide::class, Section::class);
    }

    public function getRedAttribute()
    {
        if ($this->color) {
            $rgb = explode(',', $this->color);
            return $rgb[0];
        }
    }
    public function getGreenAttribute()
    {

        if ($this->color) {
            $rgb = explode(',', $this->color);
            return $rgb[1];
        }
    }
    public function getBlueAttribute()
    {
        if ($this->color) {
            $rgb = explode(',', $this->color);
            return $rgb[2];
        }
    }
}