<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class UpdatePyramidGroupJob extends Job implements SelfHandling
{
    private $group;
    private $title;
    private $inside_triangle;
    private $content;
    private $position;
    private $slide_id;

    /**
     * Create a new job instance.
     *
     * @param $group
     * @param $title
     * @param $content
     * @param $inside_triangle
     * @param $position
     * @param $slide_id
     */
    public function __construct($group, $title, $content, $inside_triangle, $position,$slide_id)
    {
        $this->group           = $group;
        $this->title           = $title;
        $this->inside_triangle = $inside_triangle;
        $this->content         = $content;
        $this->position        = $position;
        $this->slide_id = $slide_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->group->title           = $this->title;
        $this->group->inside_triangle = $this->inside_triangle;
        $this->group->content         = $this->content;
        $this->group->update();
        $this->group->slides()->sync([$this->slide_id => ['position' => $this->position]], false);
    }
}
