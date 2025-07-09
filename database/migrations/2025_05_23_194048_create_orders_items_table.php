<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_items', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger('order_id');
			$table->unsignedBigInteger('product_id');
			$table->Integer('product_price');
			$table->string('product_name');
			$table->Integer('quantity')->default(0);
			$table->unsignedBigInteger('Variants_id')->nullable();
			$table->string('Variant', 50)->nullable();
			$table->float('igst', 8, 2)->default(0);
			$table->float('cgst', 8, 2)->default(0);
			$table->float('sgst', 8, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('order_id')->references('id')->on('orders') ->cascadeOnDelete();
            $table->foreign('product_id')->references('id')->on('products') ->cascadeOnDelete();
            $table->foreign('Variants_id')->references('id')->on('product_variants') ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_items');
    }
}
