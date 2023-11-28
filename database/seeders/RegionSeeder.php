<?php

namespace Database\Seeders;

use App\Models\Region;
use App\Models\location;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = location::select('region')->distinct()->get();
       foreach($regions as $region){


        Region::create([
            'name' => $region['region']
        ]);
       }
    }
}
