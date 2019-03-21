<?php

namespace App\Http\Middleware;

use Closure;

class RedirectToPreview
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($request->has('previewSlide')) {
            $presentation = $request->route('presentation');

            return redirect()->action('Admin\AdminPresentationsController@preview', ['id' => $presentation->id, 'slide_id' => $request->previewSlide]);
        }

        return $response;
    }
}
