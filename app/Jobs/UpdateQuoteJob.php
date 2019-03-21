<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Images\ImageHandler;
use App\Models\SlideTypes\Quote;
use App\Models\SlideTypes\QuoteRepository;
use Illuminate\Contracts\Bus\SelfHandling;

class UpdateQuoteJob extends Job implements SelfHandling
{
    private $quote;
    private $author;
    private $role;
    private $image;
    private $quoteObj;
    private $double;
    private $type;

    /**
     * Create a new job instance.
     *
     * @param Quote $quoteObj
     * @param $author
     * @param $role
     * @param $quote
     * @param $image
     * @param $double
     * @param $type
     */
    public function __construct($quoteObj, $author, $role, $quote, $image, $double, $type)
    {
        $this->quote    = $quote;
        $this->author   = $author;
        $this->role     = $role;
        $this->quote    = $quote;
        $this->image    = $image;
        $this->quoteObj = $quoteObj;
        $this->double   = $double;
        $this->type     = $type;
    }

    /**
     * Execute the job.
     *
     * @param QuoteRepository $quotes
     * @param ImageHandler $imageHandler
     * @return mixed
     */
    public function handle(QuoteRepository $quotes, ImageHandler $imageHandler)
    {
        if ($this->quoteObj->image && $this->type != 'image') {
            $imageHandler->deleteImage($this->quoteObj->image, 'splits');
            $this->image = null;
        } else {
            $this->image = $imageHandler->checkForUpdate($this->quoteObj, $this->image, 'quotes');
        }
        if ($this->type == 'image') {
            $this->author = null;
            $this->role   = null;
            $this->quote  = null;
        }


        return $quotes->update($this->quoteObj, $this->author, $this->role, $this->quote, $this->image, $this->double);

    }
}
