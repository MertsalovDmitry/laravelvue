<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees')->delete(); 
        DB::table('positions')->delete();
        DB::table('users')->delete();

        // $this->call(UsersTableSeeder::class);
        $this->call(PositionsTableSeeder::class);
        $this->call(EmployeesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
