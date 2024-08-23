<?php

namespace App\Console\Commands;

use App\Jobs\PostCreator;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

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
            $botName = 'Autobot-'.Str::random();

            while (User::where('name', $botName)->exists()) {
                $botName = "Autobot-{$i}".Str::random();
            }
            $author = User::create([
                'name' => $botName,
                'description' => 'Model-'.Str::random(5),
            ]);
            PostCreator::dispatch($author, 10);
        }

        $this->info('500 Autobots created successfully!');
    }
}
