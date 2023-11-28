<?php

namespace Database\Seeders;

use App\Models\location;
use App\Models\Quarter;
use App\Models\Township;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class QuarterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $townships_wards = location::select('township', 'quarter')->distinct()->get()->toArray();
        foreach ($townships_wards as $township_ward) {
            // Find or create the Township model instance
            $township = Township::firstOrNew(['name' => $township_ward['township']]);
            // Save the Township model if it's a new instance
            if (!$township->exists) {
                $township->save();
            }
            // Create the Ward model
            Quarter::create([
                'name' => $township_ward['quarter'],
                'township_id' => $township->id,
            ]);
        }
    }
}
