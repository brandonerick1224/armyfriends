<?php

use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @throws Exception
     */
    public function run()
    {
        DB::table('countries')->delete();
        $countries = Config::get('countries');
        if (! $countries) {
            throw new Exception("Countries config file doesn't exists or empty, did you run: php artisan vendor:publish?");
        }

        foreach($countries as $country)
            DB::table('countries')->insert($country);
    }
}
