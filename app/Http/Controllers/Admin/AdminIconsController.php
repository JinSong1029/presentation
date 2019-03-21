<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateIconRequest;
use App\Http\Requests\GetIconsRequest;
use App\Http\Requests\SaveIconsRequest;
use App\Http\Requests\UpdateIconRequest;
use App\Jobs\CreateIconJob;
use App\Jobs\SaveIconsJob;
use App\Jobs\UpdateIconJob;
use App\Models\Slide;
use App\Models\SlideTypes\Icon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminIconsController extends Controller
{

    /**
     * @var Icon
     */
    private $icon;

    /**
     * AdminImagesController constructor.
     * @param Image $image
     */
    public function __construct(Icon $icon)
    {
        $this->image = $icon;
    }

    /**
     * @param CreateIconRequest $request
     * @return mixed
     */
    public function store(CreateIconRequest $request)
    {
        return $this->dispatchFrom(CreateIconJob::class,$request);
    }

    public function update(UpdateIconRequest $request, Icon $icon)
    {
        $request['slideImage'] = $icon;
        $this->dispatchFrom(UpdateIconJob::class,$request);
    }

    public function destroy(Icon $icon)
    {
        $icon->delete();
    }

    public function getLogos(GetIconsRequest $request)
    {
        return $this->image->logos()->exceptIds($request->get('except'))->get()->toJson();
    }

    public function storeLogos(SaveIconsRequest $request)
    {
        $data['logos'] = $request->get('logos');
        $data['slide_id'] = $request->get('slide_id');

        $this->dispatchFromArray(SaveIconsJob::class,$data);
        return \Redirect::back();
    }

}
