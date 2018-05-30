<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->integer('VTHCode');
            $table->string('VTHDesc', 200)->nullable();
            $table->string('VTHType', 200)->nullable();
            $table->string('Group', 100)->unique();
            $table->string('VehTypeDesc', 200)->nullable();
            $table->string('ImageUrl', 500)->nullable();
            $table->string('VTHDescription', 200)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}
