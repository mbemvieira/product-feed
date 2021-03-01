<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            // $table->id();
            $table->string('provider', 128);
            $table->string('item_id', 128);
            $table->string('click_out_link', 512)->nullable();
            $table->string('main_photo_url', 512)->nullable();
            $table->decimal('price', 12, 2);
            $table->string('price_currency', 3);
            $table->decimal('shipping_price', 12, 2)->nullable();
            $table->string('title', 128);
            $table->string('description', 256)->nullable();
            $table->date('valid_until')->nullable();
            $table->string('brand', 128)->nullable();
            $table->dateTime('expiry_datetime');
            $table->timestamps();

            $table->primary(['provider', 'item_id']);
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
