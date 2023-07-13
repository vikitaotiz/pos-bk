<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departments')->insert([
            'uuid' => Str::uuid()->toString(),
            'name' => 'Butchery',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('departments')->insert([
            'uuid' => Str::uuid()->toString(),
            'name' => 'Grocery',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
