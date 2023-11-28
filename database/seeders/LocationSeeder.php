<?php

namespace Database\Seeders;

use App\Models\location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use League\Csv\Reader;


class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $csvFile = fopen(base_path('database/data/location.csv'), 'r');

        while (($data = fgetcsv($csvFile, 1000, ',')) !== false) {
            // Insert data into the database
            DB::table('locations')->insert([
                'region' => $data[0],
                'township' => $data[1],
                'quarter' => $data[2],
                'postal_code' => $data[3],
                // Add more columns as needed
            ]);
        }

        fclose($csvFile);
    }
}
