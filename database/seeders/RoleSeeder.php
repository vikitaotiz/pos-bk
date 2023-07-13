<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            'uuid' => Str::uuid()->toString(),
            'name' => 'Administrator',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('roles')->insert([
            'uuid' => Str::uuid()->toString(),
            'name' => 'Cashier',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('roles')->insert([
            'uuid' => Str::uuid()->toString(),
            'name' => 'Normal User',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
