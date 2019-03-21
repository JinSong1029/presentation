<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Images\ImageHandler;
use App\Models\SlideTypes\Text;
use App\Models\SlideTypes\TextsRepository;
use Illuminate\Contracts\Bus\SelfHandling;

class CreateTextJob extends Job implements SelfHandling
{
    /**
     * @var
     */
    private $text;
    /**
     * @var
     */
    private $image;
    /**
     * @var
     */
    private $slide_id;

    /**
     * Create a new job instance.
     *
     * @param $text
     * @param $image
     * @param $slide_id
     */
    public function __construct($text, $image, $slide_id)
    {
        //
        $this->text = $text;
        $this->image = $image;
        $this->slide_id = $slide_id;
    }

    /**
     * Execute the job.
     *
     * @param TextsRepository $text
     * @param ImageHandler $imageHandler
     * @return text
     */
    public function handle(TextsRepository $texts, ImageHandler $imageHandler)
    {
        $image = $imageHandler->uploadImage($this->image,'texts');
        $text = $texts->createText($this->text,$image);

        $text->slides()->attach($this->slide_id);

        return $text;
    }
}
