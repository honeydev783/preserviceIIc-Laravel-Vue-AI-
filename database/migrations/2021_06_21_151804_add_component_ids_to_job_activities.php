<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddComponentIdsToJobActivities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_activities', function (Blueprint $table) {
            $table->string('component_ids')->nullable()->after('activity_code');
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
            $table->dropColumn('component_ids');
        });
    }
}
