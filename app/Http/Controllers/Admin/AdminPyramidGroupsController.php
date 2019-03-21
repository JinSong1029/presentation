<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreatePyramidGroupRequest;
use App\Http\Requests\UpdatePyramidGroupRequest;
use App\Jobs\CreatePyramidGroupJob;
use App\Jobs\UpdatePyramidGroupJob;
use App\Models\SlideTypes\PyramidGroup;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminPyramidGroupsController extends Controller
{
    public function store(CreatePyramidGroupRequest $request)
    {
        $this->dispatchFrom(CreatePyramidGroupJob::class, $request);
    }

    /**
     * @param PyramidGroup $group
     * @param UpdatePyramidGroupRequest $request
     */
    public function update(PyramidGroup $group, UpdatePyramidGroupRequest $request)
    {
        $request['group'] = $group;
        $this->dispatchFrom(UpdatePyramidGroupJob::class, $request);
    }
    public function destroy(PyramidGroup $quote)
    {
        $quote->delete();
    }
}
