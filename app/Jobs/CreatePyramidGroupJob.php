<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\SlideTypes\PyramidGroup;
use Illuminate\Contracts\Bus\SelfHandling;

class CreatePyramidGroupJob extends Job implements SelfHandling
{
    private $title;
    private $inside_triangle;
    private $content;
    private $slide_id;
    private $position;

    /**
     * Create a new job instance.
     *
     * @param $title
     * @param $inside_triangle
     * @param $content
     * @param $slide_id
     * @param $position
     */
    public function __construct($title, $inside_triangle, $content, $slide_id, $position)
    {
        $this->title           = $title;
        $this->inside_triangle = $inside_triangle;
        $this->content         = $content;
        $this->slide_id        = $slide_id;
        $this->position        = $position;
    }

    /**
     * Execute the job.
     *
     * @param PyramidGroup $group
     */
    public function handle(PyramidGroup $group)
    {
        $group->title           = $this->title;
        $group->inside_triangle = $this->inside_triangle;
        $group->content         = $this->content;
        $group->save();

        $group->slides()->attach($this->slide_id);
        $group->slides()->sync([$this->slide_id => ['position' => $this->position]], false);

    }
}
