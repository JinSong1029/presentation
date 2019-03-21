<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateTombstoneRequest;
use App\Http\Requests\UpdateTombstoneRequest;
use App\Http\Requests\GetTombstonesRequest;
use App\Jobs\CreateTombstoneJob;
use App\Jobs\UpdateTombstoneJob;
use App\Models\SlideTypes\Tombstone;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminTombstonesController extends Controller
{
    /**
     * @var Tombstone
     */
    private $tombstone;

    /**
     * AdminTombstonesController constructor.
     * @param Tombstone $tombstone
     */
    public function __construct(Tombstone $tombstone)
    {
        $this->tombstone = $tombstone;
    }

    public function store(CreateTombstoneRequest $request)
    {
        return $this->dispatchFrom(CreateTombstoneJob::class,$request);
    }
    public function update(UpdateTombstoneRequest $request, Tombstone $tombstone)
    {
        $request['tombstone'] = $tombstone;
        return $this->dispatchFrom(UpdateTombstoneJob::class,$request);
    }

    public function destroy(Tombstone $tombstone)
    {
        $tombstone->delete();
    }
    // myone
    public function getTombstones(GetTombstonesRequest $request)
    {
        return $this->tombstone->get()->toJson();
    }
}
