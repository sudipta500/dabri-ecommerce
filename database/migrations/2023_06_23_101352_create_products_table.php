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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('flavour_name');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->unsignedBigInteger('packet_size_id');
            $table->foreign('packet_size_id')->references('id')->on('packet_sizes');
            $table->string('packating_type');
            $table->float('mrp');
            $table->float('offer_mrp');
            $table->longText('ingredient');
            $table->longText('description');
            $table->longText('benefits');
            $table->longText('consume');
            $table->string('one_image');
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
};
