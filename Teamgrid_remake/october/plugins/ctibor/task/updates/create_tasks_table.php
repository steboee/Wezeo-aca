<?php namespace Ctibor\Task\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateTasksTable extends Migration
{
    public function up()
    {
        Schema::create('ctibor_task_tasks', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->integer('project_id')->index();
            $table->integer('user_id')->index()->nullable();
            $table->boolean("completed")->default(false)->nullable();
            $table->dateTime("due_date")->nullable();
            $table->dateTime("planned_start_date")->nullable();
            $table->dateTime("planned_end_date")->nullable();
            $table->boolean('tracking')->nullable()->default(false);
            $table->integer("duration_seconds")->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ctibor_task_tasks');
    }
}
