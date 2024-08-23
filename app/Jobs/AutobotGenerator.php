<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\JSonDataClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class AutobotGenerator implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected int $count)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(JSonDataClient $client): void
    {
        $bots = $client->users('GET', 'users', ['limit' => $this->count]);

        for ($i = 0; $i < count($bots); $i++) {

            $botName = $bots[$i]->name;

            while (User::where('name', $botName)->exists()) {
                $botName = $botName."-{$i}-".Str::random(10);
            }
            $author = User::create([
                'name' => $botName,
                'email' => Str::random(10).$bots[$i]->email,
                'password' => $bots[$i]->email,
            ]);
            PostCreator::dispatch($author, $bots[$i]->id, 10);
        }
    }
}
