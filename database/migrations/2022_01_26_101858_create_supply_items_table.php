<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplyItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supply_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('supply_id')->unsigned();
            $table->bigInteger('oil_id')->unsigned();
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('supply_id')->references('id')->on('supplies')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('oil_id')->references('id')->on('oil')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supply_items');
    }
}
