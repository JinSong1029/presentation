<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateSectionRequest;
use App\Http\Requests\UpdateSectionRequest;
use App\Jobs\CreateSectionJob;
use App\Models\Section;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Redirector;

class AdminSectionsController extends Controller
{
    /**
     * @var Redirector
     */
    private $redirect;

    /**
     * AdminSectionsController constructor.
     * @param Redirector $redirect
     */
    public function __construct(Redirector $redirect)
    {
        $this->redirect = $redirect;
    }

    public function index()
    {
        return 'sdd';
    }

    public function store(CreateSectionRequest $request)
    {
        $this->dispatchFrom(CreateSectionJob::class,$request);

    }

    public function update(Section $section, UpdateSectionRequest $request)
    {
        $section->name = $request->get('name');
        $section->update();
    }

    public function destroy(Section $section)
    {
        $section->delete();
        return $this->redirect->back();
    }

    /**
     * @param Request $request
     * @param Section $section
     */
    public function sort(Request $request, Section $section)
    {
        foreach ($request->get('positions') as $k => $v) {
            $newSection = $section->findOrFail($v);
            $newSection->ordering = $k + 1;
            $newSection->update();
        }

    }
}
