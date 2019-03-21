<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateDefaultsRequest;
use App\Jobs\CreateDefaultJob;
use App\Models\Presentation\DefaultSections;
use App\Models\SlideTypes\Image;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Redirector;

class AdminDefaultsController extends Controller
{

    private $redirect;


    /**
     * AdminDefaultsController constructor.
     * @param Redirector $redirect
     */
    public function __construct(Redirector $redirect)
    {
        $this->redirect = $redirect;
    }

    public function index(DefaultSections $sections)
    {
        $sections = $sections->orderBy('ordering', 'ASC')->get();

        return view('presentations.defaults.default', compact('sections'));
    }

    public function create(DefaultSections $sections)
    {
        $sections = $sections->all();

        return view('presentations.defaults.default', compact('sections'));
    }

    public function store(CreateDefaultsRequest $request)
    {
        $this->dispatchFrom(CreateDefaultJob::class, $request);

        return $this->redirect->to('defaults');
    }

    public function edit(DefaultSections $section)
    {
        $sections = DefaultSections::all();

        return view('presentations.defaults.default', compact('sections', 'section'));
    }

    public function update(CreateDefaultsRequest $request, DefaultSections $section)
    {
        $section->name = $request->get('name');
        $section->update();

        return $this->redirect->to('defaults');
    }

    public function destroy(DefaultSections $section)
    {
        $afterSections = $toDecrease = DefaultSections::where('ordering', '>', $section->ordering)->get();

        $section->delete();

        $afterSections->map(function ($section) {
            $section->ordering -= 1;
            $section->update();
        });


        return $this->redirect->to('defaults');
    }

    public function increasePosition(DefaultSections $section)
    {

        $toDecrease = DefaultSections::where('ordering', '=', $section->ordering + 1)->first();
        $toDecrease->ordering -= 1;
        $toDecrease->update();
        $section->ordering += 1;
        $section->update();

        return $this->redirect->back();
    }

    public function decreasePosition(DefaultSections $section)
    {
        $toIncrease = DefaultSections::where('ordering', '=', $section->ordering - 1)->first();
        if ($toIncrease->name != intro_page_name()) {
            $toIncrease->ordering += 1;
            $toIncrease->update();
            $section->ordering -= 1;
            $section->update();
        }

        return $this->redirect->back();
    }
}
