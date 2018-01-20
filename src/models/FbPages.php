<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FbPages extends Model
{
    public $table = "fb_pages";

    public function reviews() {
        return $this->hasMany("App\FbReviews", "fb_page_id");
    }
}
