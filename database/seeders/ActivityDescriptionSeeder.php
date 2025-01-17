<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ActivityDescriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $titles = [
            "Preliminaries",
            "Substructure",
            "Frame Structure",
            "Suspended Floor",
            "Staircase",
            "Walling Masonry",
            "Roofing",
            "Wall Finishes",
            "Ceiling Finishes",
            "Floor Finishes",
            "Windows",
            "Doors",
            "Metal Grill Work",
            "Fixtures Fittings",
            "Plumbing Installation",
            "Fire Protection System",
            "Sanitary Installation",
            "Electrical Installation",
            "Communication",
            "Painting",
            "Air Conditioning Installation",
            "Drainage Installation",
            "External Works",
            "Swimming Pool"
        ];
        foreach($titles as $title){
            DB::table('activity_descriptions')->insert([
                'title' => $title
            ]);
        } 
    }
}
