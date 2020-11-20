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
            $table->decimal('value');
            $table->string('url_source')->nullable();
            $table->string('file_source')->nullable();
            $table->foreignId('indicator_status_id');
            $table->foreignId('disaggregation_id');
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
