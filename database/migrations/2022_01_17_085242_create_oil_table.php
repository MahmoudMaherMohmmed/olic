<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oil', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('brand_id')->unsigned();
            $table->bigInteger('type_id')->unsigned();
            $table->string('name');
            $table->string('serial_number');
            $table->text('description')->nullable();
            $table->integer('price');
            $table->integer('quantity');
			$table->string('image');
            $table->integer('status')->default(1)->comment('0=>Not Avaliable | 1=>Avaliable');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('brand_id')->references('id')->on('oil_brands')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('type_id')->references('id')->on('oil_types')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oil');
    }
}
