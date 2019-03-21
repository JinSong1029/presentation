<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Images\ImageHandler;
use App\Models\SlideTypes\GallarysRepository;
use Illuminate\Contracts\Bus\SelfHandling;

class UpdateGallaryJob extends Job implements SelfHandling
{


    public $gallary;
    public $label;
    public $desc;
    public $image;
    /**
     * @var
     */
    public $double;
    /**
     * @var
     */
    public $image2;
    /**
     * @var
     */
    public $image3;
    /**
     * @var
     */
    public $image4;

    /**
     * UpdateGallaryJob constructor.
     * @param $gallary
     * @param $label
     * @param $desc
     * @param $image
     * @param $double
     * @param $image2
     * @param $image3
     * @param $image4
     */
    public function __construct($gallary, $label, $desc, $image, $double, $image2, $image3, $image4)
    {
        $this->gallary = $gallary;
        $this->label = $label;
        $this->desc = $desc;
        $this->image = $image;
        $this->double = $double;
        $this->image2 = $image2;
        $this->image3 = $image3;
        $this->image4 = $image4;
    }

    public function handle(ImageHandler $imageHandler,GallarysRepository $repository)
    {

        // $this->image = $imageHandler->checkForUpdate($this->gallary, $this->image, 'gallarys');

        $this->image = $imageHandler->checkForUpdate($this->gallary, $this->image, 'gallarys');
        $this->image2 = $imageHandler->checkForUpdate($this->gallary, $this->image2, 'gallarys','image2');
        $this->image3 = $imageHandler->checkForUpdate($this->gallary, $this->image3, 'gallarys','image3');
        $this->image4 = $imageHandler->checkForUpdate($this->gallary, $this->image4, 'gallarys','image4');


        $gallery = $repository->updateGallery($this->gallary, $this);

        return $gallery;
    }
}
