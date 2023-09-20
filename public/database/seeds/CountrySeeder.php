<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\App;
use Countries;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Io238\ISOCountries\Models\Country;

class CountrySeeder extends Seeder
{

    /**
     * Run the database seeds.
     * @see https://github.com/propaganistas/laravel-phone
     * @see https://github.com/Monarobase/country-list
     * @see https://github.com/io238/laravel-iso-countries
     */
    public function run(): void
    {
        $countries = Countries::getList('pt', 'php');
        $parsed_countries = [];
        //for each key get the phone number formar associated
        foreach ($countries as $key => $value) {
            // add them to the database if they dont exist
            $codigo_tel = "+" . Country::find($key)->calling_code;
            if (!DB::table('pais')->where('codigo_iso', $key)->where('codigo_tel',$codigo_tel)->exists()) {
                DB::table('pais')->updateOrInsert([
                    'codigo_iso' => $key,
                    'codigo_tel' => $codigo_tel,
                ]
                );
            }
        }
    }
}
