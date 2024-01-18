<?php

namespace Database\Seeders;

use App\Models\MType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate table
        Schema::disableForeignKeyConstraints();
        DB::table('m_types')->truncate();
        Schema::enableForeignKeyConstraints();

        $types = config('m_types');
        foreach ($types as $id => $name) {
            MType::create([
                'id' => $id,
                'name' => $name
            ]);
        }
    }
}
