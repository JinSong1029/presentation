<?php

namespace App\Http\Controllers\Admin;

use App\Handlers\TagsReplacer;
use App\Http\Requests\CreatePresentationRequest;
use App\Http\Requests\UpdateKeyRequest;
use App\Http\Requests\UpdatePresentationRequest;
use App\Jobs\CreatePresentationJob;
use App\Jobs\UpdatePresentationJob;
use App\Models\Presentation;
use App\Models\Presentation\DefaultSections;
use App\Models\Presentation\PresentationRepository;

use App\Models\Slide;
use App\Models\SlideTypes\Procedure;
use App\Models\SlideTypes\Quote;
use App\Models\SlideTypes\SplitScreen;
use App\Models\SlideTypes\Tombstone;
use App\Models\SlideTypes\Text;
use App\Models\SlideTypes\Icon;
use App\Models\SlideTypes\Gallary;
use App\Models\SlideTypes\Team;
use App\Models\User;
use Artisan;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\URL;

class AdminPresentationsController extends Controller
{
    private $redirect;
    private $presentationRepo;
    private $request;

    /**
     * AdminPresentationsController constructor.
     * @param Redirector $redirect
     * @param PresentationRepository $presentationRepo
     * @param Request $request
     */
    public function __construct(Redirector $redirect, PresentationRepository $presentationRepo, Request $request)
    {
        $this->redirect         = $redirect;
        $this->presentationRepo = $presentationRepo;
        $this->request          = $request;
    }


    public function index(Request $request)
    {
        $sortBy    = $request->get('sortBy');
        $direction = $request->get('order');
        $perPage   = 10;

        $presentations = $this->presentationRepo->getPresentations(compact('sortBy', 'direction', 'perPage'), 0);

        return view('presentations.index', compact('presentations', 'request'));
    }

    public function show(Presentation $presentation)
    {

    }

    public function archived(Request $request)
    {
        $sortBy    = $request->get('sortBy');
        $direction = $request->get('order');
        $perPage   = 10;

        $presentations = $this->presentationRepo->getPresentations(compact('sortBy', 'direction', 'perPage'), 1);

        return view('presentations.index', compact('presentations', 'request'));
    }

    public function select(Request $request)
    {
        $sortBy    = $request->get('sortBy');
        $direction = $request->get('order');
        $perPage   = 10;

        $presentations = $this->presentationRepo->getPresentations(compact('sortBy', 'direction', 'perPage'), 0);

        return view('presentations.index', compact('presentations', 'request'));
    }

    public function keys(Presentation $presentation, Request $request)
    {
        $sortBy        = $request->get('sortBy');
        $direction     = $request->get('order');
        $perPage       = 10;
        $presentations = $this->presentationRepo->getPresentations(compact('sortBy', 'direction', 'perPage'), null);

        return view('presentations.keys', compact('presentations', 'request', 'presentation'));
    }

    public function updateKey(Presentation $presentation, UpdateKeyRequest $request)
    {
        if ($request->has('random')) {
            $presentation->key = generateRandomString(16);
        } else {
            $presentation->key = $request->get('key');
        }

        $presentation->update();

        return $this->redirect->to('/presentations/keys');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param DefaultSections $section
     * @return Response
     * @internal param DefaultSections $sections
     */
    public function create(DefaultSections $section)
    {

        $sections = $section->appearanceOrder()->get();

        return view('presentations.create_presentation', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreatePresentationRequest|Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreatePresentationRequest $request)
    {
        $presentation = $this->dispatchFrom(CreatePresentationJob::class, $request);

        return response()->json(['presentation' => $presentation->id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Presentation $presentation
     * @return Response
     * @internal param int $id
     */
    public function edit(Presentation $presentation)
    {
        return view('presentations.edit_presentation', compact('presentation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePresentationRequest|Request $request
     * @param Presentation $presentation
     * @return Response
     * @internal param int $id
     */
    public function update(UpdatePresentationRequest $request, Presentation $presentation)
    {

        $request['presentation'] = $presentation;
        $this->dispatchFrom(UpdatePresentationJob::class, $request);

        return $this->redirect->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Presentation $presentation
     * @return Response
     * @throws \Exception
     * @internal param int $id
     */
    public function destroy(Presentation $presentation)
    {
        $presentation->delete();

        return $this->redirect->back();
    }

    public function setActive(Presentation $presentation, Request $request)
    {
        if ($request->get('active') == 1) {
            $presentation->activeUsers()->save(auth()->user());
        } else {
            auth()->user()->presentation_id = null;
            auth()->user()->update();
        }

    }

    public function setArchived(Presentation $presentation, Request $request)
    {
        $presentation->archived = $request->get('archived');
        $presentation->update();
    }

    public function duplicate(Presentation $presentation)
    {
        $newPresentation        = $presentation->replicate();
        $newPresentation->title = $presentation->title . ' - copy';
        $newPresentation->save();
        foreach ($presentation->sections as $section) {
            $newSection = $section->replicate();
            $newSection->save();
            $newPresentation->sections()->save($newSection);

            foreach ($section->slides as $slide) {
                $newSlide             = $slide->replicate();
                $newSlide->section_id = $newSection->id;

                $newSlide->save();

                foreach ($slide->slideables() as $slideAble) {
                    $newContent = $slideAble->replicate();

                    $newContent->save();
                    $newContent->slides()->save($newSlide);
                }


            }
        }

        return $this->redirect->back();
    }

    public function preview(Presentation $presentation, Request $request)
    {
        return redirect()->action('PresentationController@index', ['slide' => $request->slide_id])
            ->withCookie(cookie()->forever('client', $presentation->key));
    }

    public function menuScreen(Presentation $presentation, Request $request)
    {
        return redirect()->action('PresentationController@menuScreen', ['slide' => $request->slide_id])
            ->withCookie(cookie()->forever('client', $presentation->key));
    }

    public function addIntro(Request $request)
    {
        $this->validate($request, [
            'add' => 'required|boolean',
        ]);
        $exitCode = Artisan::call('migrate', []);

        return response()->json();
    }

    public function changeTags(TagsReplacer $replacer)
    {
        $tombs = Tombstone::all();
        $tombs->map(function ($tomb) use ($replacer) {
            $tomb->update([
                'desc'  => $replacer->searchAndReplace($tomb->desc),
                'label' => $replacer->searchAndReplace($tomb->label),
            ]);
        });

        $procedures = Procedure::all();
        $procedures->map(function ($procedure) use ($replacer) {
            $procedure->update([
                'desc'  => $replacer->searchAndReplace($procedure->desc),
                'label' => $replacer->searchAndReplace($procedure->label),
            ]);
        });

        $quotes = Quote::all();
        $quotes->map(function ($quote) use ($replacer) {
            $quote->update([
                'quote'  => $replacer->searchAndReplace($quote->quote),
            ]);
        });
        $splits = SplitScreen::all();
        $splits->map(function ($split) use ($replacer) {
            $split->update([
                'text'  => $replacer->searchAndReplace($split->text),
            ]);
        });
        $texts = Text::all();
        $texts->map(function ($text) use ($replacer) {
            $text->update([
                'text'  => $replacer->searchAndReplace($text->text),
            ]);
        });
//        $t = Tombstone::find(4);
//        $t->update(['desc' => $replacer->searchAndReplace($t->desc)]);
    }
}


