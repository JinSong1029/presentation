<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UpdateVideoRequest;
use App\Jobs\UpdateVideoJob;
use App\Models\SlideTypes\Video;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminVideosController extends Controller
{

    public function update(UpdateVideoRequest $request, Video $video)
    {
        $request['video'] = $video;
        $this->dispatchFrom(UpdateVideoJob::class,$request);
    }

    public function destroy(Video $video)
    {
        $video->delete();
    }
}
