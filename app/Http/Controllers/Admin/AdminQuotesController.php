<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateQuoteRequest;
use App\Http\Requests\UpdateQuoteRequest;
use App\Jobs\CreateQuoteJob;
use App\Jobs\UpdateQuoteJob;
use App\Models\SlideTypes\Quote;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminQuotesController extends Controller
{

    public function store(CreateQuoteRequest $request)
    {
       return $this->dispatchFrom(CreateQuoteJob::class, $request);
    }

    public function update(Quote $quote, UpdateQuoteRequest $request)
    {
        $request['quoteObj'] = $quote;

        return $this->dispatchFrom(UpdateQuoteJob::class, $request);
    }

    public function destroy(Quote $quote)
    {
        $quote->delete();
    }
}
