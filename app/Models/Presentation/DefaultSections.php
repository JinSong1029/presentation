<?php

namespace App\Models\Presentation;

use App\Traits\SectionOrdering;
use Illuminate\Database\Eloquent\Model;

class DefaultSections extends Model
{

    use SectionOrdering;

    protected $table = 'default_sections';
    protected static $intro = 'Intro page';

    protected $fillable = ['name'];

    public $timestamps = false;

    public static function introPageName()
    {
        return static::$intro;
    }

}