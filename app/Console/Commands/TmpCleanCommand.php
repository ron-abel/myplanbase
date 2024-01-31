<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TmpCleanCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tmp:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean the storage/app/public/tmp folder';

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
        $path = storage_path('app/public/tmp');
        exec("rm -rf $path/*");
    }
}
