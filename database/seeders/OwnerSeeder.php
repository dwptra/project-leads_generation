<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Owner;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Owner::create([
            'name' => 'Dwi',
            'password' => bcrypt('123'),   
        ]);
        Owner::create([
            'name' => 'Daniel',
            'password' => bcrypt('123'),   
        ]);
    }
}
