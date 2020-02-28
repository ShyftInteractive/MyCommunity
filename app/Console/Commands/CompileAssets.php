<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CompileAssets extends Command
{
    protected $signature = 'rebase:compile {--production}';

    protected $description = 'Run the compile commands';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        passthru("rm -Rf public/assets");

        $this->info("Cleanup...\n");

        if ($this->option('production')) {
            passthru("yarn run prod");
        } else {
            passthru("yarn run dev");
        }
    }
}
