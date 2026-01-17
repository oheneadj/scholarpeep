<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = [
            ['name' => 'United States', 'code' => 'USA'],
            ['name' => 'United Kingdom', 'code' => 'GBR'],
            ['name' => 'Canada', 'code' => 'CAN'],
            ['name' => 'Australia', 'code' => 'AUS'],
            ['name' => 'Germany', 'code' => 'DEU'],
            ['name' => 'France', 'code' => 'FRA'],
            ['name' => 'Netherlands', 'code' => 'NLD'],
            ['name' => 'Sweden', 'code' => 'SWE'],
            ['name' => 'Switzerland', 'code' => 'CHE'],
            ['name' => 'Japan', 'code' => 'JPN'],
            ['name' => 'South Korea', 'code' => 'KOR'],
            ['name' => 'Singapore', 'code' => 'SGP'],
            ['name' => 'New Zealand', 'code' => 'NZL'],
            ['name' => 'Ireland', 'code' => 'IRL'],
            ['name' => 'Denmark', 'code' => 'DNK'],
            ['name' => 'Norway', 'code' => 'NOR'],
            ['name' => 'Finland', 'code' => 'FIN'],
            ['name' => 'Belgium', 'code' => 'BEL'],
            ['name' => 'Austria', 'code' => 'AUT'],
            ['name' => 'Spain', 'code' => 'ESP'],
            ['name' => 'Italy', 'code' => 'ITA'],
            ['name' => 'China', 'code' => 'CHN'],
            ['name' => 'India', 'code' => 'IND'],
            ['name' => 'Brazil', 'code' => 'BRA'],
            ['name' => 'South Africa', 'code' => 'ZAF'],
            ['name' => 'Nigeria', 'code' => 'NGA'],
            ['name' => 'Kenya', 'code' => 'KEN'],
            ['name' => 'Ghana', 'code' => 'GHA'],
            ['name' => 'Egypt', 'code' => 'EGY'],
            ['name' => 'Morocco', 'code' => 'MAR'],
        ];

        foreach ($countries as $country) {
            Country::firstOrCreate(
                ['code' => $country['code']],
                [
                    'name' => $country['name'],
                    'slug' => Str::slug($country['name']),
                ]
            );
        }
    }
}
