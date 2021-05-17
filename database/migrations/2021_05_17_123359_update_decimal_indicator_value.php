<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDecimalIndicatorValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('indicator_values', function (Blueprint $table) {
            $table->decimal('value_quantitative', 8, 5)->change();
        });

        Schema::table('_link_effects_indicators', function (Blueprint $table) {
            $table->decimal('baseline_quantitative', 8, 5)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('indicator_values', function (Blueprint $table) {
            $table->decimal('value_quantitative', 8, 2)->change();
        });

        Schema::table('_link_effects_indicators', function (Blueprint $table) {
            $table->decimal('baseline_quantitative', 8, 2)->change();
        });
    }
}
