<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_activities', function (Blueprint $table) {
            $table->id();
            $table->integer('category');
            $table->string('activity_code');
            $table->text('description');
            $table->text('activity_description')->nullable();
            $table->integer('quantity');
            $table->integer('unit');
            $table->float('rate');
            $table->float('amount');
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
        Schema::dropIfExists('job_activities');
    }
}
