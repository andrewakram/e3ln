<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email');
            $table->string('image')->nullable(true);
            $table->string('business_id')->nullable(true);
            $table->string('tax_num');
            $table->string('lat');
            $table->string('lng');
            $table->string('description_en');
            $table->string('description_ar');
            $table->string('website');
            $table->enum('open_hours', ['24H','12H','6H']);
            $table->time('open_from');
            $table->time('open_to');
            $table->bigInteger('shop_id')->unsigned();
            $table->bigInteger('category_id')->unsigned();
            $table->foreign('shop_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('shop_details');
    }
}
