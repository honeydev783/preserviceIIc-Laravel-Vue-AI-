<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMainEntryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('MainEntry', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->float('cost_m2');
            $table->string('unit_m2');
            $table->float('cost_sf');
            $table->string('unit_sf');
            $table->integer('category');           
            $table->string('element_code'); 
            $table->integer('is_story');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('MainEntry');
    }
}
