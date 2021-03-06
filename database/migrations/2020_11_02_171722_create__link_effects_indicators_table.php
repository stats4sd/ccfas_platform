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
            $table->foreignId('effect_id')->constrained()->onDelete('cascade');
            $table->foreignId('indicator_id')->constrained()->onDelete('cascade');
            $table->foreignId('level_attribution_id')->constrained('level_attributions')->onDelete('cascade');
            $table->decimal('baseline_quantitative')->nullable();
            $table->string('baseline_qualitative')->nullable();
            
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
