<?php

namespace Vellum\Models;

class Type
{

    const ARTICLE = 'article';
    const PAGE = 'page';

    public static function all()
    {
        return [
            self::ARTICLE => 'Article',
            self::PAGE  => 'Page'
        ];
    }


}
