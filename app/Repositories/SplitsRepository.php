<?php


namespace App\Repositories;


use App\Models\SlideTypes\SplitScreen;
use App\Models\User;

class SplitsRepository extends Repository
{
    protected $createFromFields = ['text', 'image', 'left'];
    protected $updateFromFields = ['text', 'image', 'left', 'use_presentation_color'];

    public function __construct(SplitScreen $screen)
    {
        $this->object = $screen;
    }

}