<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Images\ImageHandler;
use App\Models\SlideTypes\QuoteRepository;
use Illuminate\Contracts\Bus\SelfHandling;

class CreateQuoteJob extends Job implements SelfHandling
{
    private $author;
    private $role;
    private $quote;
    private $image;
    private $slide_id;
    private $position;
    private $double;

    /**
     * Create a new job instance.
     *
     * @param $author
     * @param $role
     * @param $quote
     * @param $image
     * @param $slide_id
     * @param $position
     * @param $double
     */
    public function __construct($author, $role, $quote, $image, $slide_id, $position, $double)
    {
        $this->author   = $author;
        $this->role     = $role;
        $this->quote    = $quote;
        $this->image    = $image;
        $this->slide_id = $slide_id;
        $this->position = $position;
        $this->double   = $double;
    }

    /**
     * Execute the job.
     *
     * @param QuoteRepository $quotes
     * @param ImageHandler $imageHandler
     * @return \App\Models\SlideTypes\Quote
     */
    public function handle(QuoteRepository $quotes, ImageHandler $imageHandler)
    {
        if ($this->image)
            $this->image = $imageHandler->uploadImage($this->image, 'quotes');

        $quote = $quotes->create($this->author, $this->role, $this->quote, $this->image, $this->double);
        $quote->slides()->attach($this->slide_id);
        $quote->slides()->sync([$this->slide_id => ['position' => $this->position]], false);

        return $quote;

    }
}
