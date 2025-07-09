<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductInventoryLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_inventory_logs', function (Blueprint $table) {
            $table->id();
			$table->string('log');
			$table->string('variant');
			$table->unsignedBigInteger('product_id');
			$table->unsignedBigInteger('user_id');
			$table->unsignedBigInteger('product_variant_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('product_id')->references('id')->on('products') ->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users') ->cascadeOnDelete();
            $table->foreign('product_variant_id')->references('id')->on('product_variants') ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_inventory_logs');
    }
}
