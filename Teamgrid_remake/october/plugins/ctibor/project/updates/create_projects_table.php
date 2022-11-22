<?php namespace Ctibor\Project\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateProjectsTable extends Migration
{
    public function up()
    {
        Schema::create('ctibor_project_projects', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->index();
            $table->string('name');
            $table->string('description');
            $table->boolean("completed")->default(false)->nullable();
            $table->dateTime("due_date")->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ctibor_project_projects');
    }
}
