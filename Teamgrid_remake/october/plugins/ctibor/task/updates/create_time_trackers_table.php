<?php namespace Ctibor\Task\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateTimeTrackersTable extends Migration
{
    public function up()
    {
        Schema::create('ctibor_task_time_trackers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('task_id')->index();
            $table->integer('user_id')->index();
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->integer("duration_seconds")->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ctibor_task_time_trackers');
    }
}
