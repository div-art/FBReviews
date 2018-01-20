<?php

namespace DivArt\FBReviews\Facades;
use Illuminate\Support\Facades\Facade;

class FBReviews extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'fbreview';
    }
}