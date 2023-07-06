<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MergeCurrentBranchWithAnother extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'merge';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Merge current branch with another branch';

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
        $mergeBranch = $this->ask("What is your merging branch?");
        $branch = $this->ask("Which branch you want merge?", "current");
        if($branch == "current"){
            $branch = shell_exec("git rev-parse --abbrev-ref HEAD");
        }
        exec("git checkout '".$mergeBranch."'");
        exec("git merge ".$branch);
        exec("git push");
        exec("git checkout ".$branch);
        $this->info("done");
        return true;
    }
}
