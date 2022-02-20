<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToAdditionalServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('additional_services', function (Blueprint $table) {
            $table->bigInteger('model_id')->unsigned()->after('price');
            $table->bigInteger('cylinder_id')->unsigned()->after('model_id');
            $table->integer('manufacture_year')->after('cylinder_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('additional_services', function (Blueprint $table) {
            //
        });
    }
}
