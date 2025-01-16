<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ResourceComponentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('resource_components')->insert([
            'component_id'=>'28',
            'resource_type'=>'labour',
            'quantity'=>0.8,
            'unit'=>'Hr',
            'rate'=>50
        ]);
        DB::table('resource_components')->insert([
            'component_id'=>'56',
            'resource_type'=>'Steel Erector',
            'quantity'=>0.8,
            'unit'=>'Hr',
            'rate'=>80
        ]);
        DB::table('resource_components')->insert([
            'component_id'=>'114',
            'resource_type'=>'Heavy Duty Drill',
            'quantity'=>0.8,
            'unit'=>'Hr',
            'rate'=>25
        ]);
        DB::table('resource_components')->insert([
            'component_id'=>'78',
            'resource_type'=>'Welding Plant',
            'quantity'=>0.8,
            'unit'=>'Hr',
            'rate'=>35
        ]);
        DB::table('resource_components')->insert([
            'component_id'=>'325',
            'resource_type'=>'1/2"x4"x8" Mild Steel Plate',
            'quantity'=>0.0258,
            'unit'=>'Sheet',
            'rate'=>125
        ]);
        DB::table('resource_components')->insert([
            'component_id'=>'273',
            'resource_type'=>'5/8 Dia.x4-1/2 Long Galv  Carriage wood bolt',
            'quantity'=>2,
            'unit'=>'Length',
            'rate'=>85
        ]);
        DB::table('resource_components')->insert([
            'component_id'=>'200',
            'resource_type'=>'3/4" Dia MS Bar',
            'quantity'=>2.489,
            'unit'=>'Lbs',
            'rate'=>10
        ]);
        DB::table('resource_components')->insert([
            'component_id'=>'318',
            'resource_type'=>'Welding Rod',
            'quantity'=>0.1333,
            'unit'=>'Lbs',
            'rate'=>8
        ]);
    }
}
