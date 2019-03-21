<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckKeyRequest;
use App\Http\Requests\GetPresentationRequest;
use App\Models\Presentation;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class PresentationController extends Controller
{

    /**
     * PresentationController constructor.
     */
    public function __construct()
    {
        $this->middleware('authOrClient', ['only' => 'index']);
    }

    public function index(Request $request)
    {


        $slideId = $request->slide;
        if ($request->slide) {
            $presentation         = Presentation::setEagerLoads([])->where('key', '=', $request->cookie('client'))->first();
            $presentation->slides = $presentation->slides->filter(function ($slide) use ($slideId) {
                return $slide->id == $slideId;
            });
        } else
            $presentation = Presentation::where('key', '=', $request->cookie('client'))->first();

        if ( !$presentation)
            return redirect()->to('presentations/guard')->withErrors('Presentation with this key does not exist');

        return view('frontend.new_presentation', compact('presentation', 'slideId'));
    }

    public function menuScreen(Request $request)
    {
        $slideId = $request->slide;
        if ($request->slide) {
            $presentation         = Presentation::setEagerLoads([])->where('key', '=', $request->cookie('client'))->first();
            $presentation->slides = $presentation->slides->filter(function ($slide) use ($slideId) {
                return $slide->id == $slideId;
            });
        } else
            $presentation = Presentation::where('key', '=', $request->cookie('client'))->first();

        if ( !$presentation)
            return redirect()->to('presentations/guard')->withErrors('Presentation with this key does not exist');

        return view('frontend.presentation_menu', compact('presentation', 'slideId'));
    }

    public function screenIntroTemplate(Request $request) {
        $presentation = Presentation::where('key', '=', $request->cookie('client'))->first();
        if ( !$presentation)
            return redirect()->to('presentations/guard')->withErrors('Presentation with this key does not exist');
        return view('frontend.templates.screen_intro', compact('presentation'));
    }

    public function contentsTemplate(Request $request) {
        $presentation = Presentation::where('key', '=', $request->cookie('client'))->first();
        if ( !$presentation)
            return redirect()->to('presentations/guard')->withErrors('Presentation with this key does not exist');
        $hide_noti_flag = 0;
        if ($request->session()->has('hide_noti')) {
            $hide_noti_flag = $request->session()->get('hide_noti');
        }
        return view('frontend.templates.contents', compact('presentation', 'hide_noti_flag'));
    }

    /**
     * Set Session for contents template noti field
     */
    public function setSession(Request $request) {
        $request->session()->put($request->input('key_name'), $request->input('key_value'));
        return 'success';
    }

    public function logosViewTemplate(Request $request) {
        $presentation = Presentation::where('key', '=', $request->cookie('client'))->first();
        if ( !$presentation)
            return redirect()->to('presentations/guard')->withErrors('Presentation with this key does not exist');
        return view('frontend.templates.logos_view', compact('presentation'));
    }

    public function contentViewTemplate(Request $request) {
        $presentation = Presentation::where('key', '=', $request->cookie('client'))->first();
        if ( !$presentation)
            return redirect()->to('presentations/guard')->withErrors('Presentation with this key does not exist');
        return view('frontend.templates.content_view', compact('presentation'));
    }

    public function contentPlainViewTemplate(Request $request) {
        $presentation = Presentation::where('key', '=', $request->cookie('client'))->first();
        if ( !$presentation)
            return redirect()->to('presentations/guard')->withErrors('Presentation with this key does not exist');
        return view('frontend.templates.content_plain_view', compact('presentation'));
    }

    public function iconsViewTemplate(Request $request) {
        $presentation = Presentation::where('key', '=', $request->cookie('client'))->first();
        if ( !$presentation)
            return redirect()->to('presentations/guard')->withErrors('Presentation with this key does not exist');
        return view('frontend.templates.icons_view', compact('presentation'));
    }

    public function imagesViewTemplate(Request $request) {
        $presentation = Presentation::where('key', '=', $request->cookie('client'))->first();
        if ( !$presentation)
            return redirect()->to('presentations/guard')->withErrors('Presentation with this key does not exist');
        return view('frontend.templates.images_view', compact('presentation'));
    }

    public function teamViewTemplate(Request $request) {
        $presentation = Presentation::where('key', '=', $request->cookie('client'))->first();
        if ( !$presentation)
            return redirect()->to('presentations/guard')->withErrors('Presentation with this key does not exist');
        return view('frontend.templates.team_view', compact('presentation'));
    }

    public function tombstoneViewTemplate(Request $request) {
        $presentation = Presentation::where('key', '=', $request->cookie('client'))->first();
        if ( !$presentation)
            return redirect()->to('presentations/guard')->withErrors('Presentation with this key does not exist');
        return view('frontend.templates.tombstone_view', compact('presentation'));
    }

    public function fullImageViewTemplate(Request $request) {
        $presentation = Presentation::where('key', '=', $request->cookie('client'))->first();
        if ( !$presentation)
            return redirect()->to('presentations/guard')->withErrors('Presentation with this key does not exist');
        return view('frontend.templates.full_image_view', compact('presentation'));
    }

    public function fullVideoViewTemplate(Request $request) {
        $presentation = Presentation::where('key', '=', $request->cookie('client'))->first();
        if ( !$presentation)
            return redirect()->to('presentations/guard')->withErrors('Presentation with this key does not exist');
        return view('frontend.templates.full_video_view', compact('presentation'));
    }

    public function guard()
    {
        return view('auth.key');
    }


    public function key(GetPresentationRequest $request)
    {
        $presentation = Presentation::where('key', '=', $request->get('key'))->first();
        if ( !$presentation)
            return redirect()->back()->withErrors('Presentation with this key does not exist');

        return redirect('presentations')->withCookie(cookie()->forever('client', $presentation->key));
    }

    public function getKey(Presentation $presentation)
    {
        return view('auth.key', compact('presentation'));
    }

    public function quit(Request $request)
    {
        return back()->withCookie(\Cookie::forget('client'));
    }
}

