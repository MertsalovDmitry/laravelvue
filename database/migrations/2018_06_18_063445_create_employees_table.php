<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('employees', function(Blueprint $table) {
      // These columns are needed for Baum's Nested Set implementation to work.
      // Column names may be changed, but they *must* all exist and be modified
      // in the model.
      // Take a look at the model scaffold comments for details.
      // We add indexes on parent_id, lft, rgt columns by default.
      $table->increments('id');
      $table->integer('parent_id')->nullable()->index();
      $table->integer('lft')->nullable()->index();
      $table->integer('rgt')->nullable()->index();
      $table->integer('depth')->nullable();

      // Add needed columns here (f.ex: name, slug, path, etc.)
      // $table->string('name', 255);
      //$table->string('name', 100); //фио
      $table->string('firstname', 30); //имя
      $table->string('middlename', 30); //отчество
      $table->string('lastname', 30); //фамилия
      $table->integer('position_id')->unsigned(); //должность, из другой таблицы
      $table->decimal('salary', 8, 2)->nullable(); //зп
      $table->date('employed_at'); // дата прийома на работу

      $table->timestamps();

      $table->foreign('position_id')->references('id')->on('positions');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    $table->dropForeign('employees_position_id_foreign');
    Schema::drop('employees');
  }

}
