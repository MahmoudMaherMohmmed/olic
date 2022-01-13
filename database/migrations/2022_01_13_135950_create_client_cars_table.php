<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_cars', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('client_id')->unsigned();
            $table->bigInteger('model_id')->unsigned();
            $table->bigInteger('cylinder_id')->unsigned();
            $table->integer('manufacture_year');
            $table->integer('status')->default(1)->comment('0=>Not Avaliable | 1=>Undr Review | 2=>Approved');
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('model_id')->references('id')->on('car_models')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('cylinder_id')->references('id')->on('car_cylinders')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_cars');
    }
}
