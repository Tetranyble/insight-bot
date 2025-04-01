<?php

use Illuminate\Support\Facades\Http;
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
Route::get('nibss/products', function (\App\Services\NIBSSClient $client){
    /**
     * {
     * "responseMessage": "Success",
     * "responseCode": "00",
     * "data": [
     * {
     * "id": "538",
     * "name": "Loan settlement",
     * "status": 1
     * }
     * ]
     * }
     */
    return $client->getProducts(415);
});
Route::get('nibss/easypay', function (\App\Services\NIBSSEasyPay $client){
    $response = $client->reset();
    return $response;
});

Route::get('nibss/institutions', function (\App\Services\NIBSSEasyPay $client){
    $response = $client->institutions();
    return $response;
});
Route::get('nibss/transfer', function (\App\Services\NIBSSEasyPay $client){
    $response = $client->transfer([

    ]);
    return $response;
});
Route::get('nibss/balance', function (\App\Services\NIBSSEasyPay $client){
    $response = $client->balance([
        "channelCode" => "1",
        "targetAccountName" => "vee Test",
        "targetAccountNumber" => "0112345678",
        "targetBankVerificationNumber" => "33333333333",
        "authorizationCode" => "MA-0112345678-2022315-53097",
        "destinationInstitutionCode" => "999998",
        "billerId" => "ADC19BDC-7D3A-4C00-4F7B-08DA06684F59",
        "transactionId" => "000446250221204500123456789111"
    ]);
    return $response;
});
Route::get('nibss/create-product', function (\App\Services\NIBSSClient $client){
    /**
     * {
     * "responseMessage": "Success",
     * "responseCode": "00",
     * "data": {
     * "id": "538",
     * "biller_id": 415,
     * "name": "Loan settlement",
     * "description": "Loan settlement",
     * "createdDate": "2025-01-17T11:36:24.5974308+00:00",
     * "status": 1,
     * "amount": "0"
     * }
     * }
     */
    return $client->createProduct([
        'billerId'=> 415,
        'productName' => 'Loan settlement'
    ]);
});
Route::get('nibss/create-biller', function (\App\Services\NIBSSClient $client){
    return $client->createBiller($requestData = [
        // This is the CAC registration number of the biller
        'rcNumber' => 'RC1258977', // Example: RC123456

        // This is the name of the biller
        'name' => 'Boctrust MFB Limited', // Example: HORIZON BILLERS LTD

        // This is the address of the biller
        'address' => '26 Moloney street, Onikan, Lagos', // Example: Lagos

        // This is the biller's email address
        'email' => 'enquiries@boctrustmfb.com', // Example: horizonbillerslimited@gmail.com

        // This is the biller's phone number
        'phoneNumber' => '07015234747', // Example: 09078765436

        // This is the account number of the biller
        'accountNumber' => '0123991401', // Example: 0205678983

        // This is the account name of the biller
        'accountName' => 'Boctrust MFB Ltd', // Example: HORIZON BILLERS LTD

        // This is the bank code of the biller's account number
        'bankCode' => '998', // Example: 07

        // This is a callback URL to notify on the status of the mandate
        'mandateStatusNotificationUrl' => 'https://boctrustmfb.com/mandate/notifications', // Example: mandatestatus.com
    ]);
});
Route::get('nibss/mandate', function (\App\Services\NIBSSClient $client){

//    return $client->createEMandate([
//          "productId"=> 1,
//          "billerId"=> 1,
//          "accountNumber"=> "2222222222",
//          "bankCode"=> "058",
//          "payerName"=> "Alex lopez",
//          "mandateType"=> 2,
//          "payerAddress"=> "maryland Ikeja computer village",
//          "accountName"=> "Micheal lopez",
//          "amount"=> 100000,
//          "frequency"=> 48,
//          "narration"=> "test e mandate response",
//          "phoneNumber"=> "08028134486",
//          "subscriberCode"=> "12003074001",
//          "startDate"=> "2025-01-09T16:37:43.109Z",
//          "endDate"=> "2025-06-09T16:37:43.109Z",
//        "payerEmail" => "senenerst@gmail.com"
//    ]);
    $path = Storage::disk('public')->path('test-upload.jpg');
    return $client->createMandateDirectDebit([
        /**
         * This is a system generated unique ID of the product
         * for which the mandate was created as payment
         */
        "productId" => 538,
        /**
         *This refers to the 10-digit NUBAN (Nigerian Uniform Bank Account Number) of the
         * account on which a mandate is being created
         */
        "accountNumber" => "0937258920",
        /**
         * This is the 3-digit CBN assigned code of the bank where the account on
         * which a mandate is being created
         */
        "bankCode" => "76768",
        /**
         * This is the name under which the mandate for payment is being
         * made i.e the name of the person making the payment
         */
        "payerName" => "test",
        /**
         * This is a sample email address for the payer (e.g. payer@gmail.com)
         */
        "payerEmail" => "payermail@gmail.com",
        /**
         * Address of the payer.
         */
        "payerAddress" => "Lagos",
        /**
         *
         * string
         * This refers to the full name on the account on which a mandate is
         * being created. It includes first name, last name, and middle name
         * (if supplied), e.g., “Babajide Lesh Adewale”. This field accepts
         * both alphabetical characters and special characters.
         */
        "accountName" => "TestAccount",
        /**
         * This is the price of the product/service being purchased. It refers to the amount
         * of money to be debited as a result of the mandate. It is provided in Naira and Kobo
         * as a number with two decimals.
         */
        "amount" => "1000.00",
        /**
         * This is any comment attached to the mandate created for description where required
         */
        "narration" => "payment",
        /**
         * This is the phone number of the Payer
         */
        "phoneNumber" => "56120003622",

        /**
         * This is a Unique ID assigned to the Payer by the Payee.
         */
        "subscriberCode" => "RJ5W4G4VNTWG",

        /**
         * This refers to the date on which the mandate becomes operative.
         * This is written in the format YYYYMMDD
         */
        "startDate" => "2025-01-24T12:19:44.855Z",
        /**
         * This refers to the date on which the mandate expires. After this date, the approval to
         * perform direct debits on the account is revoked. This is written in the format YYYYMMDD.
         */
        "endDate" => "2025-11-17T08:19:44.855Z",

        /**
         * @integer
         * Refers to the ID for a biller.
         */
        "billerId" => 415,


        /**
         * This is the mandate file to be uploaded, the acceptable formats are jpeg, png & pdf.
         */
        "mandateImageFile" => [
            "name" => "mandateImageFile",
            "contents" => fopen($path,'r'),
            "filename" => "test-upload.jpg"
        ],

        ]);

//    $upscale = Http::withHeaders([
//        'Authorization' => 'Bearer '.env('NIBSS_JWT'),
//        'Accept'        => 'application/json',
//        'Content-Type'  => 'multipart/form-data',
//        'apikey' => config('services.nibss.api_key'),
//    ])->attach(
//        'mandateImageFile', // name of the file input field
//        Storage::disk('public')->path('volume.pdf') // path to the file
//    )->post('https://apitest.nibss-plc.com.ng/ndd/v2/api/MandateRequest/CreateMandateDirectDebit', [
//        "payerName" => "test",
//        "narration" => "payment",
//        "payerEmail" => "payermail@gmail.com",
//        "bankCode" => "76768",
//        "endDate" => "2024-11-15T08:19:44.855Z",
//        "productId" => "1",
//        "billerId" => "1",
//        "startDate" => "2023-11-15T08:19:44.855Z",
//        "subscriberCode" => "RJ5W4G4VNTWG",
//        "accountNumber" => "0937258920",
//        "phoneNumber" => "56120003622",
//        "amount" => "1000.00",
//        "accountName" => "TestAccount",
//        "payerAddress" => "Lagos"
//    ]);
//
//return $upscale;

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

/**
 * [
 * {
 * "institutionCode": "999000",
 * "institutionName": "Pse-Test",
 * "category": 2
 * },
 * {
 * "institutionCode": "999001",
 * "institutionName": "ADH",
 * "category": 3
 * },
 * {
 * "institutionCode": "999002",
 * "institutionName": "NPF",
 * "category": 11
 * },
 * {
 * "institutionCode": "999003",
 * "institutionName": "FETS",
 * "category": 11
 * },
 * {
 * "institutionCode": "999004",
 * "institutionName": "Teasy",
 * "category": 11
 * },
 * {
 * "institutionCode": "999009",
 * "institutionName": "PagaTech",
 * "category": 2
 * },
 * {
 * "institutionCode": "999011",
 * "institutionName": "First Bank",
 * "category": 2
 * },
 * {
 * "institutionCode": "999015",
 * "institutionName": "Parallex MFB",
 * "category": 7
 * },
 * {
 * "institutionCode": "999018",
 * "institutionName": "Trustbond",
 * "category": 7
 * },
 * {
 * "institutionCode": "999023",
 * "institutionName": "Citi Bank",
 * "category": 2
 * },
 * {
 * "institutionCode": "999033",
 * "institutionName": "UBA",
 * "category": 2
 * },
 * {
 * "institutionCode": "999035",
 * "institutionName": "Wema Bank",
 * "category": 2
 * },
 * {
 * "institutionCode": "999044",
 * "institutionName": "Access Bank",
 * "category": 2
 * },
 * {
 * "institutionCode": "999050",
 * "institutionName": "ECOBANK",
 * "category": 2
 * },
 * {
 * "institutionCode": "999052",
 * "institutionName": "Covenant MFB",
 * "category": 7
 * },
 * {
 * "institutionCode": "999057",
 * "institutionName": "Zenith Bank",
 * "category": 2
 * },
 * {
 * "institutionCode": "999058",
 * "institutionName": "GTBank",
 * "category": 2
 * },
 * {
 * "institutionCode": "999063",
 * "institutionName": "DIAMOND BANK",
 * "category": 2
 * },
 * {
 * "institutionCode": "999070",
 * "institutionName": "Fidelity",
 * "category": 2
 * },
 * {
 * "institutionCode": "999076",
 * "institutionName": "Skye Bank",
 * "category": 2
 * },
 * {
 * "institutionCode": "999078",
 * "institutionName": "NOW NOW",
 * "category": 11
 * },
 * {
 * "institutionCode": "999082",
 * "institutionName": "Keystone Bank",
 * "category": 2
 * },
 * {
 * "institutionCode": "999104",
 * "institutionName": "BOSAK",
 * "category": 7
 * },
 * {
 * "institutionCode": "999105",
 * "institutionName": "NOVA",
 * "category": 7
 * },
 * {
 * "institutionCode": "999107",
 * "institutionName": "Mutual Benefits",
 * "category": 7
 * },
 * {
 * "institutionCode": "999116",
 * "institutionName": "VFD MFB",
 * "category": 7
 * },
 * {
 * "institutionCode": "999140",
 * "institutionName": "WEMA MOBILE",
 * "category": 11
 * },
 * {
 * "institutionCode": "999214",
 * "institutionName": "FCMB",
 * "category": 2
 * },
 * {
 * "institutionCode": "999215",
 * "institutionName": "UNITY BANK",
 * "category": 2
 * },
 * {
 * "institutionCode": "999221",
 * "institutionName": "Stanbic Ibtc",
 * "category": 2
 * },
 * {
 * "institutionCode": "999232",
 * "institutionName": "Sterling Bank",
 * "category": 2
 * },
 * {
 * "institutionCode": "999998",
 * "institutionName": "Psuedo",
 * "category": 2
 * },
 * {
 * "institutionCode": "999999",
 * "institutionName": "NIBSS",
 * "category": 1
 * }
 * ]
 */
