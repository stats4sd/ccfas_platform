<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinkEffectsIndicatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('_link_effects_indicators', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('effect_id');
            $table->unsignedBigInteger('indicator_id');
            $table->unsignedBigInteger('level_attribution_id');
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
        Schema::dropIfExists('_link_effects_indicators');
    }
}
