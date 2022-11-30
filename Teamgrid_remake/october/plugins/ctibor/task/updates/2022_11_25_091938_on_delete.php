<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OnDelete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ctibor_task_tasks', function (Blueprint $table) {
            $table->integer('project_id')->index()->onDelete('cascade');
        });
        Schema::table('ctibor_task_time_trackers', function (Blueprint $table) {
            $table->integer('task_id')->index()->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
