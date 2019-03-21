<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateImageRequest;
use App\Http\Requests\GetLogosRequest;
use App\Http\Requests\SaveLogosRequest;
use App\Http\Requests\UpdateImageRequest;
use App\Jobs\CreateImageJob;
use App\Jobs\SaveLogosJob;
use App\Jobs\UpdateImageJob;
use App\Models\Slide;
use App\Models\SlideTypes\Image;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminImagesController extends Controller
{

    /**
     * @var Image
     */
    private $image;

    /**
     * AdminImagesController constructor.
     * @param Image $image
     */
    public function __construct(Image $image)
    {
        $this->image = $image;
    }

    /**
     * @param CreateImageRequest $request
     * @return mixed
     */
    public function store(CreateImageRequest $request)
    {
        return $this->dispatchFrom(CreateImageJob::class,$request);
    }
    public function update(UpdateImageRequest $request, Image $image)
    {
        $request['slideImage'] = $image;
        $this->dispatchFrom(UpdateImageJob::class,$request);
    }

    public function getLogos(GetLogosRequest $request)
    {
        return $this->image->logos()->exceptIds($request->get('except'))->get()->toJson();
    }

    public function storeLogos(SaveLogosRequest $request)
    {
        $data['logos'] = $request->get('logos');
        $data['slide_id'] = $request->get('slide_id');

        $this->dispatchFromArray(SaveLogosJob::class,$data);
        return \Redirect::back();
    }

}
