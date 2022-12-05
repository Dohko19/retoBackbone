<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->string('zipcode');
            $table->string('settlement');
            $table->string('settlement_type');
            $table->string('municipality');
            $table->string('state');
            $table->string('city')->nullable();
            $table->string('d_cp')->nullable();
            $table->string('state_code')->nullable();
            $table->string('office_code')->nullable();
            $table->string('settlement_type_code')->nullable();
            $table->string('municipality_code')->nullable();
            $table->string('settlement_id')->nullable();
            $table->string('zone')->nullable();
            $table->string('city_code')->nullable();
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
        Schema::dropIfExists('locations');
    }
};
