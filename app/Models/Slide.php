<?php

namespace App\Models;


use App\Models\SlideTypes\Image;
use App\Models\SlideTypes\Icon;
use App\Models\SlideTypes\Team;
use App\Models\SlideTypes\Procedure;
use App\Models\SlideTypes\PyramidGroup;
use App\Models\SlideTypes\Quote;
use App\Models\SlideTypes\SliderContentInterface;
use App\Models\SlideTypes\SplitScreen;
use App\Models\SlideTypes\Text;
use App\Models\SlideTypes\Tombstone;
use App\Models\SlideTypes\Video;
use App\Models\SlideTypes\Gallary;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{

    protected $table         = 'slides';
    protected $fillable      = ['name', 'type', 'color','ordering','section_id'];
    protected $with          = ['images', 'tombstones', 'texts', 'videos', 'procedures', 'quotes', 'groups', 'icons', 'gallarys', 'teams','splits'];
    protected $withoutMargin = [
        'picture',
        'logo',
        'video',
    ];


    public function slideables()
    {
        return collect($this->getRelations())->collapse();
    }

    public function images()
    {
        return $this->morphedByMany(Image::class, 'slideable')->withPivot('position');
    }

    public function icons()
    {
        return $this->morphedByMany(Icon::class, 'slideable')->withPivot('position');
    }

    public function teams()
    {
        return $this->morphedByMany(Team::class, 'slideable')->withPivot('position');
    }

    public function gallarys()
    {
        return $this->morphedByMany(Gallary::class, 'slideable')->withPivot('position');
    }

    public function tombstones()
    {
        return $this->morphedByMany(Tombstone::class, 'slideable')->withPivot('position');
    }

    public function texts()
    {
        return $this->morphedByMany(Text::class, 'slideable');
    }

    public function videos()
    {
        return $this->morphedByMany(Video::class, 'slideable');
    }

    public function procedures()
    {
        return $this->morphedByMany(Procedure::class, 'slideable');
    }

    public function createContent(SliderContentInterface $sliderContent)
    {
        return $sliderContent->createEmptySlideContent();
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function quotes()
    {
        return $this->morphedByMany(Quote::class, 'slideable')->withPivot('position');
    }

    public function splits()
    {
        return $this->morphedByMany(SplitScreen::class, 'slideable')->orderBy('id', 'ASC');
    }
    public function splitsForFrontend()
    {
        return $this->morphedByMany(SplitScreen::class, 'slideable')->orderBy('left', 'DESC');
    }

    public function groups()
    {
        return $this->morphedByMany(PyramidGroup::class, 'slideable')->withPivot('position');
    }

    public function hasSplitInSection($left)
    {
        return $this->splits()->where('left', $left)->count();
    }

    public function marginForMedia()
    {
        if (in_array($this->type, $this->withoutMargin)) {
            return '0';
        }

        return 1;
    }
}