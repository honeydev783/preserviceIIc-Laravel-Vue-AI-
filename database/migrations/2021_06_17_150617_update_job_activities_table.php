<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateJobActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('job_activities', function (Blueprint $table) {
            $table->dropColumn(['activity_description','quantity', 'unit','rate','amount']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('job_activities', function (Blueprint $table) {
            $table->text('activity_description');
            $table->integer('quantity');
            $table->integer('unit');
            $table->float('rate');
            $table->float('amount');            
        });
    }
}
