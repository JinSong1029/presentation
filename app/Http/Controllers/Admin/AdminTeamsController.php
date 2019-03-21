<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Http\Requests\GetTeamsRequest;
use App\Jobs\CreateTeamJob;
use App\Jobs\UpdateTeamJob;
use App\Models\SlideTypes\Team;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminTeamsController extends Controller
{
    /**
     * @var Team
     */
    private $team;

    /**
     * AdminTeamsController constructor.
     * @param Team $team
     */
    public function __construct(Team $team)
    {
        $this->team = $team;
    }

    public function store(CreateTeamRequest $request)
    {
        return $this->dispatchFrom(CreateTeamJob::class,$request);
    }
    public function update(UpdateTeamRequest $request, Team $team)
    {
        $request['team'] = $team;
        return $this->dispatchFrom(UpdateTeamJob::class,$request);
    }

    public function destroy(Team $team)
    {
        $team->delete();
    }
    // myone
    public function getTeams(GetTeamsRequest $request)
    {
        return $this->team->get()->toJson();
    }
}
