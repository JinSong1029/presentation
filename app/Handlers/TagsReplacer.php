<?php

namespace App\Handlers;


use DOMDocument;

class TagsReplacer
{

    protected $document;
    protected $hTag;
    protected $result;
    protected $tagReplacements = [
        'h1' => 'wmo-rich-heading',
        'h2' => 'wmo-rich-subheading',
        'h3' => 'wmo-rich-medium',
    ];

    protected $text = '';


    /**
     * TagsReplacer constructor.
     */
    public function __construct()
    {
        $this->document = new DOMDocument();
    }

    public function searchAndReplace($html)
    {
        if ( !$html) {
            return $html;
        }
        $this->text = $html;
        foreach ($this->tagReplacements as $tagName => $replacement) {
            $this->text = preg_replace('/<'.$tagName.'>(.*?)<\/'.$tagName.'>/', '<p class="'.$replacement.'">$1</p>', $this->text);
        }
        return $this->text;

//        $this->document->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
//
//        foreach ($this->tagReplacements as $tagName => $replacement) {
//            $hTags = $this->document->getElementsByTagName($tagName);
//
//            $count = $hTags->length;
//            if ($count) {
//                for ($i = 1; $i <= $count; $i++) {
//                    $tag = $this->document->getElementsByTagName($tagName)[0];
//                    if ($tag)
//                        $this->replaceTag($this->document->getElementsByTagName($tagName)[0], $replacement);
//                }
//            }
//        }


        $markup = substr($this->document->saveHTML($this->document->getElementsByTagName('body')->item(0)), 6, -7);
        $markup = str_replace("\n", "", $markup);

        return $markup;
    }

    public function replaceTag(\DOMNode $tag, $replacement)
    {
        /** @var \DOMNode $parent */
        $parent = $tag->parentNode;

        if ($parent->nodeName == 'li') {
            $replacer = $this->document->createElement('li', $tag->textContent);
            \Log::info('tag without li');
            $replacer->setAttribute('class', $replacement);
            $list = $parent->parentNode;

            $list->replaceChild($replacer, $parent);
        } else {
            \Log::info('tag without li');
            $replacer = $this->document->createElement('p', $tag->textContent);
            $replacer->setAttribute('class', $replacement);
            $parent->replaceChild($replacer, $tag);
        }
    }
}