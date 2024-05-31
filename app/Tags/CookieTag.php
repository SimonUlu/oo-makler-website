<?php

namespace App\Tags;

use Statamic\Tags\Tags;

class CookieTag extends Tags
{
    /**
     * The {{ cookie_tag }} tag.
     *
     * @return string|array
     */
    public function index()
    {
        return request()->cookie('__cookie_consent');
    }

    /**
     * The {{ cookie_tag:example }} tag.
     *
     * @return string|array
     */
    public function example()
    {
        return request()->cookie('__cookie_consent');
    }
}
