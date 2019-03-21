<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Images\ImageHandler;
use App\Models\SlideTypes\Gallary;
use App\Models\SlideTypes\GallarysRepository;
use Illuminate\Contracts\Bus\SelfHandling;

class CreateGallaryJob extends Job implements SelfHandling
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
    private $image2;
    /**
     * @var
     */
    private $image3;
    /**
     * @var
     */
    private $image4;
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
     * @param $image2
     * @param $image3
     * @param $image4
     * @param $slide_id
     * @param $position
     * @param $double
     */
    public function __construct($label, $desc, $image, $image2, $image3, $image4, $slide_id,$position, $double)
    {
        //
        $this->label = $label;
        $this->desc = $desc;
        $this->image = $image;
        $this->image2 = $image2;
        $this->image3 = $image3;
        $this->image4 = $image4;
        $this->slide_id = $slide_id;
        $this->position = $position;
        $this->double = $double;
    }

    /**
     * Execute the job.
     *
     * @param GallarysRepository $gallary
     * @param ImageHandler $imageHandler
     * @return Gallary
     */
    public function handle(GallarysRepository $gallarys, ImageHandler $imageHandler)
    {
        $image = $imageHandler->uploadImage($this->image,'gallarys');
        $image2 = $imageHandler->uploadImage($this->image2,'gallarys');
        $image3 = "";
        $image4 = "";
        if($this->double) {
            $image3 = $imageHandler->uploadImage($this->image3,'gallarys');
            $image4 = $imageHandler->uploadImage($this->image4,'gallarys');
        }
        $gallary = $gallarys->createGallary($this->label,$image,$image2,$image3,$image4,$this->desc,$this->double);

        $gallary->slides()->attach($this->slide_id);
        $gallary->slides()->sync([$this->slide_id => ['position' => $this->position]], false);

        return $gallary;
    }
}
