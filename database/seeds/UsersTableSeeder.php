<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $start = microtime(true);

        //factory(App\User::class, 1)->create();        

        DB::table('users')->insert([
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => bcrypt('123456'),
          ]);

        $time = microtime(true) - $start;
        printf("Скрипт выполнялся %.4F сек. \n", $time);
          
    }
}
