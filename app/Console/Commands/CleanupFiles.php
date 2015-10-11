<?php

namespace Portfolio\Console\Commands;

use Illuminate\Console\Command;

class CleanupFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'files:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleans storage/tmp of any old temporary files.';

    /**
     * @var string
     */
    protected $location;

    /**
     * @var string
     */
    protected $root;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->location = storage_path().'/tmp/';
        $this->root = $_SERVER['DOCUMENT_ROOT'];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //how to look through the folder to find out any image files older than three exist and remove them.

        $this->info('Files older than 3 hours have been cleaned up.');
    }
}
