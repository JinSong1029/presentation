<?php


namespace App\Models\SlideTypes;


class TombstonesRepository
{
    /**
     * @var Tombstone
     */
    private $tombstone;

    /**
     * TombstonesRepository constructor.
     * @param Tombstone $tombstone
     */
    public function __construct(Tombstone $tombstone)
    {
        $this->tombstone = $tombstone;
    }

    /**
     * @param $label
     * @param $desc
     * @param $image
     * @param $double
     * @return Tombstone
     */
    public function createTombstone($label, $desc, $image, $double)
    {
        $this->tombstone->label  = $label;
        $this->tombstone->desc   = $desc;
        $this->tombstone->image  = $image;
        $this->tombstone->double = $double;

        $this->tombstone->save();

        return $this->tombstone;

    }
}