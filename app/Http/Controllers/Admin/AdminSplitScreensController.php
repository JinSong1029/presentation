<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateSplitScreenRequest;
use App\Http\Requests\UpdateSplitScreenRequest;
use App\Jobs\AddSplitJob;
use App\Jobs\UpdateSplitJob;
use App\Models\SlideTypes\SplitScreen;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminSplitScreensController extends Controller
{
    public function store(CreateSplitScreenRequest $request)
    {
        return $this->dispatchFrom(AddSplitJob::class, $request);
    }

    public function update(SplitScreen $screen, UpdateSplitScreenRequest $request)
    {
        $request['screen'] = $screen;

        return $this->dispatchFrom(UpdateSplitJob::class, $request);
    }

    public function destroy(SplitScreen $screen)
    {
        $screen->slides()->detach();
        $screen->delete();
    }
}
