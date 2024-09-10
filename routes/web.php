<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('nibss/reset', function (\App\Services\NIBSSClient $client){

    $response = $client->reset();
    return $response;
});

Route::get('nibss/mandate', function (\App\Services\NIBSSClient $client){

    return $client->createMandateDirectDebit([
            'accountNumber' => '4920139942',
            'productId' => '1',
            'bankCode' => '998',
            'payerName' => 'JhqWlXgHmXOLBZbbHnVB',
            'payerAddress' => 'w1q30q8h6f',
            'accountName' => 'zcqjtmhtjv',
            'amount' => '2000',
            'Narration' => 'zcqjtmhtjv',
            'phoneNumber' => '08074521351',
            'PayerEmailAddress' => 'zcqjtmhtjv@mailinator.com',
            'subscriberCode' => 'CHI4920139942',
            'startDate' => '2024-07-18',
            'endDate' => '2024-12-30',

            'MandateImageFile' => [
                'contents' => fopen(Storage::disk('public')->path('volume.pdf'), 'r'),
                'filename' => 'volume.pdf'
            ],
            'PayerEmail' => 'hechebiri@nibss-plc.com.ng',
            'BillerId' => '1',
        ]);
});

Route::get('customer', function (){
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
        "AccountOfficerCode" => "3453"
    ]);
});
