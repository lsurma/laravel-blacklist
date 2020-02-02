<?php

namespace LSurma\LaravelBlacklist\Commands;

use Illuminate\Console\Command;
use LSurma\LaravelBlacklist\Database\Seeds\BlacklistSeeder;

class Seed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blacklist:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed blacklists with basic data';

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
        $seeder = (new BlacklistSeeder())->run();
    }
}
