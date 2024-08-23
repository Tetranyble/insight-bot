<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('pint:clean', function () {
    $this->comment('Reformat and remove unused imports...');
    Process::run('php ./vendor/bin/pint', function (string $type, string $output) {
        echo $output;
    });
    $this->comment('Done!');
})->describe('Reformat and remove unused import.');
