<?php

namespace Database\Seeders;

use App\Models\Admin;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminSeeder extends Seeder
{
    /**
     * The current Faker instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * Create a new seeder instance.
     *
     * @return void
     */
    public function __construct(Faker $faker)
    {
        $this->faker = $faker;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Truncate table
        Schema::disableForeignKeyConstraints();
        DB::table('admins')->truncate();
        Schema::enableForeignKeyConstraints();

        $admins = [
            [
                'name' => 'Admin',
                'login_id' => 'Admin',
                'password' => bcrypt('abcd1234'),
            ],
        ];

        foreach ($admins as $admin) {
            $admin = Admin::create($admin);
        }
    }
}
