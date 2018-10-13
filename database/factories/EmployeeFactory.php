<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Employee::class, function (Faker\Generator $faker) {
    $faker = Faker\Factory::create('ru_RU');
    $gender = $faker->randomElements(['male', 'female'])[0];
    $ru_lastname = $faker->lastName();
    if ($gender == 'female'){
        $ru_lastname .= 'а';
    }
    return [
        //'name' => $faker->name,
        'firstname' => $faker->firstName($gender),
        'middlename' => $faker->middleName($gender),
        'lastname' =>  $ru_lastname,
        'salary' => $faker->numberBetween($min = 100, $max = 1000),
        'employed_at' => $faker->date($format = 'Y-m-d', $max = 'now'),
        // 'parent_id' => function () {
        //     $max = App\Employee::max('depth');
        //     return App\Employee::get()->where('depth', '==', $max)->random()->id;
        //     //return App\Employee::get()->random()->id;
        // },
        'position_id' => function () {
            $dir = App\Position::get()->first();
            return App\Position::all()->where('name', '!=', $dir->name)->random()->id;
        },
    ];
});