<?php

namespace DivArt\FBReviews\Controllers;

use App\Http\Controllers\Controller;
use DivArt\FBReviews\Exceptions\EmptyFacebookUrlException;
use DivArt\FBReviews\Exceptions\WrongFacebookResponseException;
use DivArt\FBReviews\Exceptions\DoNotHavePageFacebookException;
use App\FbReviews;
use App\FbPages;

class FbController extends Controller
{
    public function __construct() {
        if( ! session_id()) {
            session_start();
        }

        $this->set_config();   
    }

    public function set_config() {
        $this->endpoints = [];
        $this->endpoints['basepath'] = "https://graph.facebook.com/";
        $this->endpoints['get_access'] = $this->endpoints['basepath'] . "oauth/access_token?&redirect_uri=" . url('/fbreview/oauth') . "&client_id=" . config('fbreview.fb_api_key') . "&client_secret=" . config('fbreview.fb_secret_key') . "&code=";
        $this->endpoints['account_me'] = $this->endpoints['basepath'] . "/me/accounts?access_token=";
    }

    public function access_token() {
        if ( ! empty(request()->code)) {
            $response = json_decode(@file_get_contents($this->endpoints['get_access'] . request()->code));
            
            if ( ! empty($response->access_token)) {
                return $this->account_me($response->access_token);
            }
        }
        throw new WrongFacebookResponseException('Wrong Facebook Response');
    }

    public function account_me($access_token) {
        $response = json_decode(@file_get_contents($this->endpoints['account_me'] . $access_token));
        $fb_page = FbPages::find($_SESSION["fb_page_id"]);
        $page = false;
        
        foreach($response->data as $p) {
            if ($p->id == $fb_page->page_id) {
                $page = $p;
            }
        }

        if ($page) {
            $fb_page->access_token = $page->access_token;
            $fb_page->save();

            return $this->reviews($page->access_token, $page->id, $fb_page->id);
        }

        throw new DoNotHavePageFacebookException("You do not have access to this Facebook page");
    }

    public function reviews($access_token, $page_id, $fb_page_id) {
        $response = json_decode(@file_get_contents($this->endpoints['basepath'] . $page_id . "/ratings?access_token=" . $access_token));
        $exists = FbReviews::get()->pluck('hash')->toArray();
        $reviews = [];
        if ($response->data) {
            foreach($response->data as $r) {
                if ( ! in_array(md5($r->review_text), $exists)) {
                    $rw = new FbReviews;
                    $rw->fb_page_id = $fb_page_id;
                    $rw->hash = md5($r->review_text);
                    $rw->text = $r->review_text;
                    $rw->rating = $r->rating;
                    $rw->user = json_encode($r->reviewer);
                    $rw->date = strtotime($r->created_time);
                    $rw->save();
                }
                $reviews[] = $r;
            }
            
        }
        return $reviews;
    }

    public function get() {
        if (request()->url) {
            $fb_page_id = $this->getFackebookPageId(request()->url);
            if ( ! FbPages::where("page_id", $fb_page_id)->count()) {
                $page = new FbPages;
                $page->url = request()->url;
                $page->page_id = $fb_page_id;
                $page->access_token = "";
                $page->save();
            } else {
                return FbPages::where("page_id", $fb_page_id)->first()->reviews;
            }

            $_SESSION["fb_page_id"] = $page->id;

            $oauth_uri = "https://facebook.com/dialog/oauth?client_id=" . config('fbreview.fb_api_key') . "&redirect_uri=" . url('/fbreview/oauth') . "&scope=manage_pages&state=code";
            return redirect($oauth_uri);
        }

        throw new EmptyFacebookUrlException('Empty Facebook Url');
    }

    public function getFackebookPageId($url) {
        $response = json_decode(@file_get_contents($this->endpoints['basepath'] . $url . "/?access_token=" . config("fbreview.fb_api_key") . "|" . config("fbreview.fb_secret_key")));
        return $response->id;
    }
}