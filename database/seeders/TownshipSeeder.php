<?php

namespace Database\Seeders;

use App\Models\Region;
use App\Models\location;
use App\Models\Township;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TownshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions_townships = Location::select('region', 'township')->distinct()->get()->toArray();
        foreach ($regions_townships as $region_township) {
            // Find or create the Township model instance
            $region = Region::firstOrNew(['name' => $region_township['region']]);
            // Save the Township model if it's a new instance
            if (!$region->exists) {
                $region->save();
            }
            // Create the Ward model
            Township::create([
                'name' => $region_township['township'],
                'region_id' => $region->id,
            ]);
        }
    }
}
