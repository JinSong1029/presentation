<?php


namespace App\Models\SlideTypes;


class IconsRepository
{
    /**
     * @var Icon
     */
    private $icon;

    /**
     * IconsRepository constructor.
     * @param Icon $icon
     */
    public function __construct(Icon $icon)
    {
        $this->icon = $icon;
    }

    /**
     * @param $label
     * @param $desc
     * @param $image
     * @param $double
     * @return Icon
     */
    public function createIcon($label, $desc, $image, $double)
    {
        $this->icon->label  = $label;
        $this->icon->desc   = $desc;
        $this->icon->image  = $image;
        $this->icon->double = $double;

        $this->icon->save();

        return $this->icon;

    }
}