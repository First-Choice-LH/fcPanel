<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('client_id');
            $table->unsignedInteger('jobsite_id');
            $table->unsignedInteger('supervisor_id');
            $table->unsignedInteger('position_id');
            $table->unsignedInteger('employee_id')->nullable();
            $table->unsignedInteger('assigned_by')->nullable();
            $table->unsignedInteger('last_updated_by')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->string('comments')->nullable();

            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('jobsite_id')->references('id')->on('jobsites');
            $table->foreign('supervisor_id')->references('id')->on('supervisors');
            $table->foreign('position_id')->references('id')->on('positions');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('assigned_by')->references('id')->on('users');
            $table->foreign('last_updated_by')->references('id')->on('users');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
