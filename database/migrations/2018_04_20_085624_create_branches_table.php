<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->integer('BranchCode')->unique();
            $table->string('BranchName', 2000)->nullable();
            $table->integer('DistArea');
            $table->string('DistAreaName', 1000)->nullable();
            $table->integer('OpArea');
            $table->string('OpAreaName', 1000);
            $table->string('Country', 1000)->nullable();
            $table->string('CountryName', 1000);
            $table->string('BranchLat', 255);
            $table->string('BranchLong', 255);
            $table->string('City', 500);
            $table->string('State', 500);
            $table->string('Telephone', 50);
            $table->string('Telephone1', 50);
            $table->string('Fax', 50);
            $table->string('Telex', 100);
            $table->string('Email', 100);
            $table->string('ArabicBranchName', 100);
            $table->string('OperationAreaName', 100);
            $table->text('Schedule');

            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('branches');
    }
}
