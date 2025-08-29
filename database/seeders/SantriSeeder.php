<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Santri;

class SantriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Santri::factory()->count(30)->create();
    }
}
