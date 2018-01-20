<?php

namespace DivArt\FBReviews;
use App\FbPages;

class FBReviews
{
    public function getByID($fb_page_id) {
        $page = FbPages::where("page_id", $fb_page_id)->first();
        return $page ? $page->reviews : [];
    }

    public function getByUrl($url) {
        $page = FbPages::where("url", $url)->first();
        return $page ? $page->reviews : [];
    }
}