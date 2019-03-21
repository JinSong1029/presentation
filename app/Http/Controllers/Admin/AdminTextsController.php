<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UpdateTextRequest;
use App\Jobs\UpdateTextJob;
use App\Models\Slide;
use App\Models\SlideTypes\Text;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminTextsController extends Controller
{
    /**
     * @var Text
     */
    private $text;
    /**
     * @var Slide
     */
    private $slide;

    /**
     * AdminTextsController constructor.
     * @param Text $text
     * @param Slide $slide
     */
    public function __construct(Text $text, Slide $slide)
    {
        $this->text = $text;
        $this->slide = $slide;
    }

    public function store(UpdateTextRequest $request)
    {
        $this->text->text = $request->get('text');
        $this->text->slides()->attach($request->get('slide_id'));
        $this->text->save();
    }

    public function update(UpdateTextRequest $request, Text $text)
    {
        $text->text = $request->get('text');
        $text->update();
        $request['text'] = $text;
        return $this->dispatchFrom(UpdateTextJob::class,$request);
    }


    public function destroy(Text $text)
    {
        $text->delete();
    }
}
