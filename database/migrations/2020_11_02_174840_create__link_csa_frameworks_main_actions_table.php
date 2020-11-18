<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinkCsaFrameworksMainActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('_link_csa_frameworks_main_actions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('csa_framework_id')->constrained('csa_frameworks')->onDelete('cascade');
            $table->foreignId('main_action_id')->constrained('main_actions')->onDelete('cascade');
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
        Schema::dropIfExists('_link_csa_frameworks_main_actions');
    }
}
