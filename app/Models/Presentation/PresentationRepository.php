<?php

namespace App\Models\Presentation;


use App\Models\BaseRepository;
use App\Models\Presentation;

class PresentationRepository extends BaseRepository
{
    /**
     * @var Presentation
     */
    private $presentation;


    /**
     * PresentationRepository constructor.
     * @param Presentation $presentation
     */
    public function __construct(Presentation $presentation)
    {
        $this->presentation = $presentation;
    }

    public function createPresentation($name, $client, $image, $color)
    {
        $this->presentation->title            = $name;
        $this->presentation->client           = $client;
        $this->presentation->key              = generateRandomString(16);
        $this->presentation->image            = $image;
        $this->presentation->color            = $color;
        $this->presentation->save();

        return $this->presentation;
    }

    public function updatePresentation($presentation, $job)
    {
        $presentation->client = $job->client;
        $presentation->title  = $job->title;
        $presentation->image  = $job->image;
        $presentation->color  = $job->color;

        $presentation->update();

        return $presentation;
    }

    public function getPresentations(array $params, $archived)
    {
        if ($this->isSortable($params)) {
            return $this->presentation->ofActiveState($archived)->orderBy($params['sortBy'], $params['direction'])->paginate($params['perPage']);
        }

        return $this->presentation->ofActiveState($archived)->paginate($params['perPage']);
    }
}