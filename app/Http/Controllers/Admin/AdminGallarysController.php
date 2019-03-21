<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateGallaryRequest;
use App\Http\Requests\UpdateGallaryRequest;
use App\Jobs\CreateGallaryJob;
use App\Jobs\UpdateGallaryJob;
use App\Models\SlideTypes\Gallary;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminGallarysController extends Controller
{
    /**
     * @var Gallary
     */
    private $gallary;

    /**
     * AdminGallarysController constructor.
     * @param Gallary $gallary
     */
    public function __construct(Gallary $gallary)
    {
        $this->gallary = $gallary;
    }

    public function store(CreateGallaryRequest $request)
    {
        return $this->dispatchFrom(CreateGallaryJob::class,$request);
    }
    public function update(UpdateGallaryRequest $request, Gallary $gallary)
    {
        $request['gallary'] = $gallary;
        return $this->dispatchFrom(UpdateGallaryJob::class,$request);
    }

    public function destroy(Gallary $gallary)
    {
        $gallary->delete();
    }
}
