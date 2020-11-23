<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndicatorValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indicator_values', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('link_effect_indicator_id')->constrained('_link_effects_indicators')->onDelete('cascade');
            $table->decimal('value_quantitative')->nullable();
            $table->string('value_qualitative')->nullable();
            $table->string('url_source')->nullable();
            $table->string('file_source')->nullable();
            $table->foreignId('indicator_status_id')->nullable();
            $table->foreignId('disaggregation_id')->nullable();
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
        Schema::dropIfExists('indicator_values');
    }
}
