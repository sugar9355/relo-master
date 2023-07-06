<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PushToCurrentBranch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'push:current';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Push all code to current branch';

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
        $message = $this->ask("What is your commit message?");
        exec("git add .");
        exec("git commit -m '".$message."'");
        exec("git push");
        $this->info("done");
        return true;
    }
}
