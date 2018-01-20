<?php

namespace DivArt\FBReviews\Commands;

use Illuminate\Console\Command;
use App\FbPages;

class FBReviewsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fbreview:scrap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $pages = FbPages::get();
        foreach($pages as $p) {
            $controller = app()->make("\DivArt\FBReviews\Controllers\FbController");
            $controller->reviews($p->access_token, $p->page_id, $p->id);
        }
    }
}
