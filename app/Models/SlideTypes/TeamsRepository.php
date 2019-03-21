<?php


namespace App\Models\SlideTypes;


class TeamsRepository
{
    /**
     * @var Team
     */
    private $team;

    /**
     * TeamsRepository constructor.
     * @param Team $team
     */
    public function __construct(Team $team)
    {
        $this->team = $team;
    }

    /**
     * @param $label
     * @param $desc
     * @param $image
     * @param $double
     * @return Team
     */
    public function createTeam($label, $desc, $image, $double)
    {
        $this->team->label  = $label;
        $this->team->desc   = $desc;
        $this->team->image  = $image;
        $this->team->double = $double;

        $this->team->save();

        return $this->team;

    }
}