<?php


namespace App\Models\SlideTypes;


class GallarysRepository
{
    /**
     * @var Gallary
     */
    private $gallary;

    /**
     * GallarysRepository constructor.
     * @param Gallary $gallary
     */
    public function __construct(Gallary $gallary)
    {
        $this->gallary = $gallary;
    }

    /**
     * @param $label
     * @param $desc
     * @param $image
     * @param $image2
     * @param $image3
     * @param $image4
     * @param $double
     * @return Gallary
     */
    public function createGallary($label, $image, $image2, $image3, $image4, $desc, $double)
    {
        $this->gallary->label  = $label;
        $this->gallary->image  = $image;
        $this->gallary->image2 = $image2;
        $this->gallary->image3 = $image3;
        $this->gallary->image4 = $image4;
        $this->gallary->desc   = $desc;
        $this->gallary->double = $double;

        $this->gallary->save();

        return $this->gallary;

    }

    public function updateGallery($gallery, $job)
    {
        $gallery->label  = $job->label;
        $gallery->desc   = $job->desc;
        $gallery->image  = $job->image;
        $gallery->image2 = $job->image2;
        $gallery->image3 = $job->image3;
        $gallery->image4 = $job->image4;
        $gallery->double = $job->double;

        $gallery->update();

        return $gallery;
    }
}