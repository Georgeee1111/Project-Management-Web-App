<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Priority;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Priority::create(['name' => 'low']);
        Priority::create(['name' => 'medium']);
        Priority::create(['name' => 'high']);
    }
}

