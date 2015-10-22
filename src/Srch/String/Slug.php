<?php
namespace Srch\String;

use URLify;

class Slug
{
    /**
     * Generate a slug version from a text
     * "ThIs is MY te$x*t" => "this-is-my-text"
     *
     * @param  String $text The text to transform
     * @return String       Slug version of the text
     */
    public static function generate($text)
    {
        //remove whitespaces from begin/end
        $text = trim($text);

        //the URLify removes some words, we dont need it
        URLify::$remove_list = [];
        //filter the text and transform on a slug
        $text = URLify::filter($text);

        //just continue with valid chars
        $text = preg_replace('/[^a-zA-Z0-9_-]/s', '', $text);

        return $text;
    }
}