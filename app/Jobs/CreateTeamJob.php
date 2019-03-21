<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Images\ImageHandler;
use App\Models\SlideTypes\Team;
use App\Models\SlideTypes\TeamsRepository;
use Illuminate\Contracts\Bus\SelfHandling;

class CreateTeamJob extends Job implements SelfHandling
{
    /**
     * @var
     */
    private $label;
    /**
     * @var
     */
    private $desc;
    /**
     * @var
     */
    private $image;
    /**
     * @var
     */
    private $slide_id;
    /**
     * @var
     */
    private $position;
    /**
     * @var
     */
    private $double;

    /**
     * Create a new job instance.
     *
     * @param $label
     * @param $desc
     * @param $image
     * @param $slide_id
     * @param $position
     * @param $double
     */
    public function __construct($label, $desc, $image, $slide_id,$position, $double)
    {
        //
        $this->label = $label;
        $this->desc = $desc;
        $this->image = $image;
        $this->slide_id = $slide_id;
        $this->position = $position;
        $this->double = $double;
    }

    /**
     * Execute the job.
     *
     * @param TeamsRepository $team
     * @param ImageHandler $imageHandler
     * @return Team
     */
    public function handle(TeamsRepository $teams, ImageHandler $imageHandler)
    {
        $image = $imageHandler->uploadImage($this->image,'teams');
        $team = $teams->createTeam($this->label,$this->desc,$image,$this->double);

        $team->slides()->attach($this->slide_id);
        $team->slides()->sync([$this->slide_id => ['position' => $this->position]], false);

        return $team;
    }
}
