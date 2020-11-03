<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('product_type_id')->constrained('products_types')->onDelete('cascade');
            $table->text('audience')->nullable();
            $table->decimal('audience_size')->nullable();
            $table->text('publication')->nullable();
            $table->text('distribution')->nullable();
            $table->date('publication_date')->nullable();
            $table->string('publication_url')->nullable();
            $table->text('partner')->nullable();
            $table->text('info_hosted')->nullable();
            $table->string('url')->nullable();
            $table->text('access_conditions')->nullable();
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
        Schema::dropIfExists('products');
    }
}
