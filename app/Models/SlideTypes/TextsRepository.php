<?php


namespace App\Models\SlideTypes;


class TextsRepository
{
    /**
     * @var Texts
     */
    private $texts;

    /**
     * TextsRepository constructor.
     * @param Texts $texts
     */
    public function __construct(Texts $texts)
    {
        $this->texts = $texts;
    }

    /**
     * @param $text
     * @param $image
     * @return Texts
     */
    public function createText($text, $image)
    {
        $this->texts->text  = $text;
        $this->texts->image  = $image;

        $this->texts->save();

        return $this->texts;

    }
}