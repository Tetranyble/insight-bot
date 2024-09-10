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

Artisan::command('one:insight', function () {
    $this->comment('Run request against bankone');
    $customer =  new \App\Services\BankOneClient();
    return $customer->createCustomer([
        "TransactionTrackingRef" => "66c9f5ae60f6fe01e78b573a",
        "AccountOpeningTrackingRef" => "66c9f5ae60f6fe01e78b573a",
        "ProductCode" =>"107",
        "LastName" =>"Mary",
        "OtherNames" =>"Genny",
        "BVN" =>"22656024483",
        "PhoneNo" =>"08103469132",
        "PlaceOfBirth" =>"Bauchi",
        "DateOfBirth" =>"2024-08-24",
        "Address" => "No 31 Afolabi Street, allen Avenue, Ikeja ,Lagos",
        "NextOfKinPhoneNo" =>"09032432322",
        "NextOfKinName" =>"Counsel Okpabi",
        "HasSufficientInfoOnAccountInfo" =>true,
        "email" =>"counselokpabijs@gmail.com",
        "Gender" =>"male",
        "NationalIdentityNo" => "31303938831",
        "AccountOfficerCode" => "52"
    ]);
    $this->comment('Done!');
})->describe('Run a request bankone create customer API.');
