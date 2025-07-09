<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger('product_id');	
			$table->unsignedBigInteger('user_id');	
			$table->string('variants');	
			$table->string('ids');	
			$table->Integer('qty');	
			$table->Integer('alert_qty')->default(1);	
			$table->Integer('amount');	
			$table->Integer('status')->default(1);	
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('product_id')->references('id')->on('products') ->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users') ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variants');
    }
}
