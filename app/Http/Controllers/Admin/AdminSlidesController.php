<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateSlideRequest;
use App\Http\Requests\UpdateSlideRequest;
use App\Jobs\AttachExistingLogoJob;
use App\Jobs\CreateSlideJob;
use App\Jobs\DeleteLogoJob;
use App\Models\Presentation;
use App\Models\Section;
use App\Models\Slide;
use App\Models\SlideTypes\Image;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Redirector;


class AdminSlidesController extends Controller
{
    public function store(CreateSlideRequest $request, Redirector $redirect)
    {
        $slide = $this->dispatchFrom(CreateSlideJob::class, $request);

        return $slide;//$redirect->to('presentations/' . $request->get('presentationId') . '/edit');
    }

    public function create()
    {
        return view('presentations.slides.add_slide');
    }

    public function edit(Presentation $presentation, Slide $slide, Request $request)
    {
        if ($request->has('preview') && $request->preview)
            return redirect()->action('PresentationController@index', ['slide' => $slide->id])
                ->withCookie(cookie()->forever('client', $presentation->key));

        $subslide = $request->get('subslide');

        $engagedPositions = $slide->slideables()->lists('original.pivot_position')->toArray();

        return view('presentations.slides.edit', compact('slide', 'presentation', 'subslide', 'engagedPositions'));
    }

    public function update(Slide $slide, UpdateSlideRequest $request)
    {
        $slide->name = $request->get('name');
        $slide->update();
    }

    public function sort(Request $request, Slide $slide)
    {
        foreach ($request->get('positions') as $k => $v) {
            $newSlide           = $slide->findOrFail($v);
            $newSlide->ordering = $k + 1;
            $newSlide->update();
        }
    }

    public function destroy(Slide $slide)
    {
        $slide->delete();
    }

    public function deleteItem(Slide $slide, Request $request)
    {
        $object = \App::make('App\Models\SlideTypes\\'.$request->get('itemType'));
        $item   = $object->find($request->get('itemId'));
        if (count($item->slides) > 1) {
            $item->slides()->detach($slide->id);
        } else {
            $item->delete();
        }
    }

    public function saveLogo(Slide $slide, Request $request)
    {
        $request['slide'] = $slide;
        $this->dispatchFrom(AttachExistingLogoJob::class, $request);

    }

    public function reorderItems(Slide $slide, Request $request)
    {
        foreach ($request->get('positions') as $k => $v) {
            $item = $slide->slideables()->where('id', $k)->first();
            $item->slides()->sync([$slide->id => ['position' => $v]], false);
        }
    }

    public function deleteLogo(Slide $slide, Request $request)
    {
        $request['slide'] = $slide;
        $this->dispatchFrom(DeleteLogoJob::class, $request);
        $response['message'] = 'ok';

        return \Response::json($response);
    }

    public function test(Request $request)
    {
        $slide = Slide::find($request->get('id'));

        return $slide->images;
    }

    public function changeColor(Slide $slide, Request $request)
    {
        $this->validate($request, ['color' => 'required']);

        $slide->update([
            'color' => $request->color ? 1 : 0,
        ]);
    }

    public function move(Slide $slide, Request $request)
    {
        /** @var Section $section */
        $section = Section::findOrFail($request->get('section'));

        if ($section->isIntro() && $section->slides()->count()) {
            return response()->json(['message' => 'The intro section can only contain one slide.'], 422);
        }
        $position = $section->lastSlidePosition();

        \Log::info('last position ' . $position);
        $needToAddBlock = $slide->section->isIntro();
        $slide->update([
            'ordering'   => $position,
            'section_id' => $section->id,
        ]);

        return response()->json([
            'appendAddBlock' => $needToAddBlock,
            'section'        => $section->id,
            'position'       => $position,
            'hideAddBlock'   => $section->isIntro(),
        ]);
    }
}
