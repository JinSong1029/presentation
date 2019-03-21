<?php

namespace App\Models\SlideTypes;


class QuoteRepository
{
    /**
     * @var Quote
     */
    private $quote;

    /**
     * QuoteRepository constructor.
     * @param Quote $quote
     */
    public function __construct(Quote $quote)
    {
        $this->quote = $quote;
    }

    /**
     * @param $author
     * @param $role
     * @param $quote
     * @param $image
     * @param $double
     * @return Quote
     */
    public function create($author, $role, $quote, $image, $double)
    {
        $this->quote->author = $author;
        $this->quote->role   = $role;
        $this->quote->quote  = $quote;
        $this->quote->image  = $image;
        $this->quote->double = $double;

        $this->quote->save();

        return $this->quote;
    }

    /**
     * @param $quoteObj Quote
     * @param $author
     * @param $role
     * @param $quote
     * @param $image
     * @param $double
     * @return mixed
     */
    public function update($quoteObj, $author, $role, $quote, $image, $double)
    {
        $quoteObj->author = $author;
        $quoteObj->role   = $role;
        $quoteObj->quote  = $quote;
        $quoteObj->image  = $image;
        $quoteObj->double = $double;

        $quoteObj->update();

        return $quoteObj;
    }


}