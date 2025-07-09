<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariantNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variant_names', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger('product_id');	
			$table->string('name');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('product_id')->references('id')->on('products') ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('variant_names');
    }
}
