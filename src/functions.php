<?php
/**
 * Create function shortLink if it is not exists
 */
if ( ! function_exists('fbreview')) {
    function shortLink()
    {
        return app('fbreview');
    }
}