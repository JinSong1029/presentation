<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Slide;
use App\Models\SlideTypes\Icon;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class SaveIconsJob extends Job implements SelfHandling
{
    use DispatchesJobs;
    private $slide_id;
    private $logos;
    private $slide;

    /**
     * Create a new job instance.
     *
     * @param $slide_id
     * @param $logos
     */
    public function __construct($slide_id, $logos)
    {
        $this->slide_id = $slide_id;
        $this->logos    = $logos;
    }

    /**
     * Execute the job.
     *
     * @param Icon $image
     * @param Slide $slides
     * @return mixed
     */
    public function handle(Icon $image, Slide $slides)
    {
        $this->slide    = $slides->find($this->slide_id);
        $attached = [];
        $detached = [];

        foreach ($this->logos as $logo) {

            $logo['slide_id'] = $this->slide_id;
            if ( !$logo['attachedLogoId'] && !$logo['detachedLogoId']) {
                if ( !array_key_exists('id', $logo)) {
                    $this->newImage($logo);
                } else {
                    $logo['slideImage'] = $image->find($logo['id']);
                    $this->dispatchFromArray(UpdateIconJob::class, $logo);
                }
            } else {
                if ($logo['attachedLogoId']) {
                    $this->slide->images()->attach($logo['attachedLogoId']);
                    $this->slide->images()->updateExistingPivot($logo['attachedLogoId'], ['position' => $logo['position']]);
                }

                if ($logo['detachedLogoId']) {
                    $this->slide->images()->detach($logo['detachedLogoId']);
                    $image = Icon::find($logo['detachedLogoId']);
                    if ($image->slides->isEmpty()) {
                        $image->delete();
                    }
                }
                if ($logo['image'] instanceof UploadedFile) {
                    $this->newImage($logo);
                }
            }
        }

    }

    public function newImage($logo)
    {
        $newLogo = $this->dispatchFromArray(CreateIconJob::class, $logo);
        $this->slide->images()->updateExistingPivot($newLogo->id, ['position' => $logo['position']]);

    }
}
