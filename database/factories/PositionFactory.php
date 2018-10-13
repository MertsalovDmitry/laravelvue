<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
// $factory->define(App\Position::class, function (Faker\Generator $faker) {   

//     return [
//         'name' => $faker->word,
//     ];
// });
//require  __DIR__ . '\../../vendor/fzaninotto/faker/src/autoload.php';


$factory->define(App\Position::class, function (Faker\Generator $faker) {   
    $faker = Faker\Factory::create('ru_RU');
    return [
        'name' => $faker->unique()->jobTitle,
    ];
});