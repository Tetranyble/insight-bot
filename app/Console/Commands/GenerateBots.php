<?php

namespace App\Console\Commands;

use App\Jobs\AutobotGenerator;
use Illuminate\Console\Command;

class GenerateBots extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'autobots:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate 500 unique Autobots every hour';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        for ($i = 0; $i < 500; $i++) {
            if ($i % 10 === 0) {
                AutobotGenerator::dispatch(10);
            }
        }

        $this->info('500 Autobots created successfully!');
    }
}
