<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientPositionRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_position_rates', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedInteger('client_id');
            $table->unsignedInteger('position_id');
            $table->decimal('rate');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('position_id')->references('id')->on('positions');
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
        Schema::dropIfExists('client_position_rates');
    }
}
