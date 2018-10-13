<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
//use App\Employee;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $start1 = microtime(true);

        $start2 = microtime(true);
        // Очистка таблицы перед новым заполнением    
        DB::table('employees')->delete();   
        $time2 = microtime(true) - $start2;
        printf("Удаление из бд выполнялось %.4F сек. \n", $time2);
        
        $start3 = microtime(true);
        // Переменные 
        $employee_count = env('EMP_COUNT_SEED'); // кол-во сотрудников
        if (!$employee_count){
            $employee_count = 500;
        }
        $director_count = env('DIR_COUNT_SEED'); // кол-во директоров, root, depth = 0
        if (!$director_count){
            $director_count = 1;
        }
        $depth_tree = env('DEPTH_TREE'); // глубина вложенности дерева
        if (!$depth_tree){
            $depth_tree = 7;
        }

        // Переменные для цикла заполнения руководителей
        $count = 0; // для участия в цикле, подсчет кол-ва выборки для функции slice
        $for_count = ($employee_count - $director_count) / $depth_tree; //кол-во сотрудников на 1 уровень дерева
        $parent; // переменная для сохранения родителей и использования в след итерации цикла
        $offset = 0; // смещение, необходимо для функции slice

        //Создаем заданное кол-во директоров
        $faker = Faker\Factory::create('ru_RU');
        $gender='male';
        
        for ($i = 0; $i < $director_count; $i++){
            $gender = $faker->randomElements(['male', 'female'])[0];
            $ru_lastname = $faker->lastName();
            if ($gender == 'female'){
                $ru_lastname .= 'а';
            }
            factory(App\Employee::class)->create([
                //'name' => $faker->name,
                'firstname' => $faker->firstName($gender),
                'middlename' => $faker->middleName($gender),
                'lastname' =>  $ru_lastname,
                'salary' => $faker->numberBetween($min = 1200, $max = 1500),
                'employed_at' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'position_id' => function () {
                    return App\Position::get()->first()->id;
                },
                'parent_id' => null,
            ]);
        }


        // Создаем заданное кол-во сотрудников
        factory(App\Employee::class, $employee_count - $director_count)->create();

        $time3 = microtime(true) - $start3;
        printf("Создание выполнялось %.4F сек. \n", $time3);

        $start4 = microtime(true);

        $emp_counter = $employee_count;
        for( $i = 0; $i < $depth_tree; $i++ ){
            $start = microtime(true);
            $count = $for_count;
            if ( $i == 0 ){
                $count = $director_count;
            }
            if ( $i == 1){
                $count = $employee_count / $depth_tree ** 2;
            }
            if ( $i == $depth_tree - 1 ){
                $count =  $employee_count;
            }
            if (  $employee_count != 0 ){   
                $employees = App\Employee::all()->slice($offset, $count, true);
                foreach ($employees as $employee){
                    if ( $i != 0 ) { 
                        $employee->makeChildOf($parent->random());
                    }
                    $employee_count--;
                    $offset++;
                }
                $parent = $employees;
            }
            $time = microtime(true) - $start;
            printf("level %d выполнялся: %.4F сек. \n", $i+1, $time);
        }

        //App\Employee::rebuild();

        $time4 = microtime(true) - $start4;
        printf("Общее наполнение выполнялось %.4F сек. \n", $time4);

        $time1 = microtime(true) - $start1;
        printf("Общий скрипт выполнялся %.4F сек. \n", $time1);
    }
}
