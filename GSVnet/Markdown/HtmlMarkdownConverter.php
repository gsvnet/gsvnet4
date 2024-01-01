<?php namespace GSVnet\Markdown;

use Illuminate\Support\Str;

class MarkdownConverter
{
    static function convertMarkdownToHtml($markdown)
    {
        return Str::markdown($markdown, [
            'html_input' => 'strip'
        ]);
    }
}