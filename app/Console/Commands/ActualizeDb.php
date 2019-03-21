<?php

namespace App\Console\Commands;

use App\Models\Presentation;
use App\Models\Presentation\DefaultSections;
use App\Models\Section;
use Illuminate\Console\Command;

class ActualizeDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'actualizeDb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

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
        $this->call('db:seed', [
            '--class' => 'MigrationsTableSeeder',
        ]);
        $this->call('migrate', []);
    }
}
