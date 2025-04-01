<?php

namespace Database\Seeders;

use App\Models\Institution;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstitutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect($this->institutions())
            ->each(function ($institution){
                Institution::create([
                    'name' => $institution['institutionName'],
                    'code' => $institution['institutionCode'],
                    'category' => $institution['category'],
                ]);
            });
    }

    public function institutions(): array
    {


        return  [
            [
                "institutionCode" => "999000",
                "institutionName" => "Pse-Test",
                "category" => 2
            ],
            [
                "institutionCode" => "999001",
                "institutionName" => "ADH",
                "category" => 3
            ],
            [
                "institutionCode" => "999002",
                "institutionName" => "NPF",
                "category" => 11
            ],
            [
                "institutionCode" => "999003",
                "institutionName" => "FETS",
                "category" => 11
            ],
            [
                "institutionCode" => "999004",
                "institutionName" => "Teasy",
                "category" => 11
            ],
            [
                "institutionCode" => "999009",
                "institutionName" => "PagaTech",
                "category" => 2
            ],
            [
                "institutionCode" => "999011",
                "institutionName" => "First Bank",
                "category" => 2
            ],
            [
                "institutionCode" => "999015",
                "institutionName" => "Parallex MFB",
                "category" => 7
            ],
            [
                "institutionCode" => "999018",
                "institutionName" => "Trustbond",
                "category" => 7
            ],
            [
                "institutionCode" => "999023",
                "institutionName" => "Citi Bank",
                "category" => 2
            ],
            [
                "institutionCode" => "999033",
                "institutionName" => "UBA",
                "category" => 2
            ],
            [
                "institutionCode" => "999035",
                "institutionName" => "Wema Bank",
                "category" => 2
            ],
            [
                "institutionCode" => "999044",
                "institutionName" => "Access Bank",
                "category" => 2
            ],
            [
                "institutionCode" => "999050",
                "institutionName" => "ECOBANK",
                "category" => 2
            ],
            [
                "institutionCode" => "999052",
                "institutionName" => "Covenant MFB",
                "category" => 7
            ],
            [
                "institutionCode" => "999057",
                "institutionName" => "Zenith Bank",
                "category" => 2
            ],
            [
                "institutionCode" => "999058",
                "institutionName" => "GTBank",
                "category" => 2
            ],
            [
                "institutionCode" => "999063",
                "institutionName" => "DIAMOND BANK",
                "category" => 2
            ],
            [
                "institutionCode" => "999070",
                "institutionName" => "Fidelity",
                "category" => 2
            ],
            [
                "institutionCode" => "999076",
                "institutionName" => "Skye Bank",
                "category" => 2
            ],
            [
                "institutionCode" => "999078",
                "institutionName" => "NOW NOW",
                "category" => 11
            ],
            [
                "institutionCode" => "999082",
                "institutionName" => "Keystone Bank",
                "category" => 2
            ],
            [
                "institutionCode" => "999104",
                "institutionName" => "BOSAK",
                "category" => 7
            ],
            [
                "institutionCode" => "999105",
                "institutionName" => "NOVA",
                "category" => 7
            ],
            [
                "institutionCode" => "999107",
                "institutionName" => "Mutual Benefits",
                "category" => 7
            ],
            [
                "institutionCode" => "999116",
                "institutionName" => "VFD MFB",
                "category" => 7
            ],
            [
                "institutionCode" => "999140",
                "institutionName" => "WEMA MOBILE",
                "category" => 11
            ],
            [
                "institutionCode" => "999214",
                "institutionName" => "FCMB",
                "category" => 2
            ],
            [
                "institutionCode" => "999215",
                "institutionName" => "UNITY BANK",
                "category" => 2
            ],
            [
                "institutionCode" => "999221",
                "institutionName" => "Stanbic Ibtc",
                "category" => 2
            ],
            [
                "institutionCode" => "999232",
                "institutionName" => "Sterling Bank",
                "category" => 2
            ],
            [
                "institutionCode" => "999998",
                "institutionName" => "Psuedo",
                "category" => 2
            ],
            [
                "institutionCode" => "999999",
                "institutionName" => "NIBSS",
                "category" => 1
            ]
        ];


    }
}
