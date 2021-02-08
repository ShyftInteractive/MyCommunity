<?php

namespace App\Console\Commands\MCS;

use App\Domain\Pages\Page;
use App\Domain\Posts\Post;
use App\Domain\Lookup\Lookup;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use App\Domain\Workspaces\Workspace;
use App\Helpers\Rebase\DatabaseHelper;

class Publish extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Search for all posts that need to be published across all customers';

    private const TIME_DIFF = 7;

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
     * @return int
     */
    public function handle()
    {
        Lookup::get()->each(function($lookup) {
            DatabaseHelper::connect($lookup->customer_id);

            Workspace::get()->each(function($workspace) {
                Post::get()->each(function($post) {
                    $this->flipPost(Carbon::now()->diffInMinutes($post->published_at, false), $post);
                });

                Page::get()->each(function($page) {
                    $this->flipPage(Carbon::now()->diffInMinutes($page->published_at, false), $page);
                });
            });
        });

        return 0;
    }

    private function flipPost(int $timeDiff, Post $post)
    {
        if ($timeDiff <= self::TIME_DIFF) {
            $post->published = true;
            $post->save();
        }
    }

    private function flipPage(int $timeDiff, Page $page) {
        if ($timeDiff <= self::TIME_DIFF) {
            $page->published = true;
            $page->save();
        }
    }
}
