<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $start = microtime(true);

        //factory(App\Position::class, 5)->create();

        // Очистка таблицы перед новым заполнением 
        DB::table('positions')->delete();

        //Свой массив должностей, в faker оч мало должностей
        $array_pos = array("Программист",
                             "Секретарь",
                             "Системный администратор",
                             "Бухгалтер",
                             "Дизайнер",
                             "Верстальщик",
                             "Менеджер",
                             "Водитель",
                             "Механик",
                             "Слесарь",
                             "Товаровед"
                            );

        //Вносим должность директор
        $position = factory(App\Position::class)->create([
            'name' => 'Директор',
          ]);

        //Вносим доп должности согласно массиву должностей выше
        foreach($array_pos as $pos){
            $position = factory(App\Position::class)->create([
                'name' => $pos,
              ]);
        };

        $time = microtime(true) - $start;
        printf("Скрипт выполнялся %.4F сек. \n", $time);
    }
}
