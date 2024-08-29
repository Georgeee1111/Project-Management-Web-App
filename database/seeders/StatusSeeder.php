<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::create(['name' => 'pending']);
        Status::create(['name' => 'in_progress']);
        Status::create(['name' => 'completed']);
        
    }
}
